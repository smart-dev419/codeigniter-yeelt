<?php namespace App\Modules\Welcome\Controllers;

use App\Controllers\BaseController;
use App\Modules\Welcome\Models\WelcomeModel;
use App\Modules\Login\Models\LoginRegisterModel;

class Welcome extends BaseController
{
    private $viewpath = 'App\Modules\Welcome\Views\\';
    private $model;

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');

        $this->LoginRegisterModel = new LoginRegisterModel();
    }
    
    /**
     * Dashboard
     */
    public function index()
	{
        $UsersKey = $_SESSION['userData']['UsersKey'];
        $Token = $_SESSION['userData']['Token'];
        $dataView['alerts'] = load_alerts(session());
        $dataView['user'] = $this->LoginRegisterModel->getUsers($UsersKey, $Token);
        
        if($_SESSION['userData']['FirstLogin'] === 1){
            //echo 1; exit();
            return redirect()->to(base_url('account/createSeller_form'))->with('success','Since this is your first time logging in, you can fill in the rest of your information. Otherwise you can always come back to this page in settings.');
        }elseif($_SESSION['userData']['FirstLogin'] === 0){    
            //echo 0; exit();    
           return $this->template($this->viewpath, "welcome", $dataView);
        }
	}

}
