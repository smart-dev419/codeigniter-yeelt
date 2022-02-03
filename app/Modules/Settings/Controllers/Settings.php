<?php namespace App\Modules\Settings\Controllers;

use App\Controllers\BaseController;
use App\Modules\Settings\Models\SettingsModel;
use App\Modules\Account\Models\AccountModel;


class Settings extends BaseController
{
    private $viewpath = 'App\Modules\Settings\Views\\';
    private $model;

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');

        $this->SettingsModel = new SettingsModel();
        $this->AccountModel = new AccountModel();
    }
    
    /**
     * Function
     */
    public function index()
	{
        $dataView['assets']['js'][] = site_url('theme/assets/modules/settings/settings.js');

        $dataView['data_seller'] = $this->SettingsModel->get_seller();
        $dataView['alerts'] = load_alerts(session());
        $this->template($this->viewpath, "index", $dataView);
	}
    
    /**
     * Function
     */
    public function process_profile()
	{
        $formdata = $this->request->getPostGet();
        if($this->SettingsModel->process_profile($formdata)) {
            echo '1';
        } else {
            echo '0';
        }
	}

    /**
     * Function
     */
    public function users()
	{
        $dataView['assets']['js'][] = site_url('theme/assets/modules/settings/users.js');

        $dataView['users'] = $this->SettingsModel->get_users();
        $dataView['alerts'] = load_alerts(session());
        $this->template($this->viewpath, "users", $dataView);
	}

    /**
     * Function
     */
    public function process_invite()
	{
        helper('email');

        // Form data
        $formdata = $this->request->getPostGet();

        // Check emailaddress
        $emailaddress = $formdata['Emailaddress'];
        if(filter_var($emailaddress, FILTER_VALIDATE_EMAIL) == FALSE) {
            echo json_encode(['status' => 'ERROR', 'error' => 'E-mailaddress not valid. Please try again.']);
            exit();
        }

        // Process invite
        $process = $this->SettingsModel->process_invite($formdata);

        // send password reset e-mail
        $dataEmail = array();
        $dataEmail['seller'] = $process['SellerData'];
        $dataEmail['emailaddress'] = $emailaddress;
        $dataEmail['invite_link_accept'] = base_url('login/accept/'.$process['UsersKey'].'/'.$process['Token'].'/'.$process['SellersKey']);
        $dataEmail['invite_link_reject'] = base_url('login/reject/'.$process['UsersKey'].'/'.$process['Token'].'/'.$process['SellersKey']);
        $sendEmail = email_send_invite($dataEmail);

        echo json_encode(['status' => 'OK', 'error' => '']);
	}

    /**
     * Function
     */
    public function delete($UsersKey, $Token)
	{
        $this->SettingsModel->delete($UsersKey, $Token);
        return redirect()->back()->with('success', 'User is deleted.');
	}

    // form
    public function logo(){
        $dataView['assets']['js'][] = site_url('theme/assets/modules/settings/users.js');
        $dataView['data'] = $this->AccountModel->get_sellers();
        $dataView['users'] = $this->SettingsModel->get_users();
        $dataView['alerts'] = load_alerts(session());
        $this->template($this->viewpath, "logo", $dataView);
    }

    public function logo_process()
    {           
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
            
        $this->SettingsModel->update_logo($newName);            
        $photo = $this->AccountModel->validatePhoto($seller, $newName, $files, $validated_logo );
        if($photo !== TRUE) 
        {
            return redirect()->back()->withInput()->with('error', $photo);
        }
        return redirect()->to(base_url('settings/logo'))->with('success', 'You info is updated.');
               
    }

}
