<?php namespace App\Modules\Account\Controllers;

use App\Controllers\BaseController;
use App\Modules\Account\Models\AccountModel;

class Account extends BaseController
{
    private $viewpath = 'App\Modules\Account\Views\\';

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');

        $this->AccountModel = new AccountModel();
    }
    
    /**
     * Function
     */
    public function account()
	{
        $dataView['assets']['js'][] = site_url('theme/assets/modules/account/account.js');

        $dataView['alerts'] = load_alerts(session());
        $dataView['data'] = $this->AccountModel->get_user();
        $this->template($this->viewpath, "account", $dataView);
	}

    /**
     * Function
     */
    public function process_account()
	{
        $formdata = $this->request->getPostGet();
        if($this->AccountModel->process_account($formdata)) {
            echo '1';
        } else {
            echo '0';
        }
	}

    public function createSeller_form(){
        $dataView = array();
        $dataView['alerts'] = load_alerts(session());
        $dataView['Title'] = 'Inert Sellers Info';
        $this->template($this->viewpath, "insertSellerForm", $dataView, false, true, false);
    }

    public function createSeller_process()
    {        
        $formdata = $this->request->getPostGet();
        $user = $this->AccountModel->get_user(); 
        $files = $this->request->getFile('logo');
        $newName = $files->getName();   
        $seller = $this->AccountModel->get_sellers(); 
        $validated_logo = $this->validate([
            'logo' => [
                'uploaded[logo]',
                'mime_in[logo,image/png]',
                'max_size[logo,4000]',
            ],
        ]); 
        
        //als first login = 1 -> required fields + validation
        if($_SESSION['userData']['FirstLogin'] === 1){
            $rules = [
                'seller_id' => 'required',
                'name' => 'required',
                'api_client_id' => 'required',
                'api_client_secret' => 'required',                
            ];

            if(!$this->validate($rules)) 
            { 
                //echo 'error';exit();
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());                
			}else
            {
                //echo 'else';exit();
                $this->AccountModel->create_seller($formdata, $newName);
                //echo 1; exit();
                $photo = $this->AccountModel->validatePhoto($seller, $newName, $files, $validated_logo );
                if($photo !== TRUE) 
                {
                    return redirect()->back()->withInput()->with('error', $photo);
                }
                return redirect()->to(base_url('overview'))->with('success', 'You info is updated.');
            }
        }elseif($_SESSION['userData']['FirstLogin'] === 0){
            //echo 'elseif'; exit();
            $this->AccountModel->create_seller($formdata, $newName);
            $photo = $this->AccountModel->validatePhoto($seller, $newName, $files, $validated_logo );
            if($photo !== TRUE) 
            {
                return redirect()->back()->withInput()->with('error', $photo);
            }
            return redirect()->to(base_url('overview'))->with('success', 'You info is updated.');
        }  
        
            
    }
    
    
}
