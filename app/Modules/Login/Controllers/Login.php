<?php namespace App\Modules\Login\Controllers;

use App\Controllers\BaseController;
use App\Modules\Login\Models\LoginModel;
use App\Modules\Login\Models\InviteModel;
use App\Modules\Login\Models\SellerConnectModel;
use App\Modules\Login\Models\LoginRegisterModel;
use App\Modules\Login\Models\LoginRecoveryModel;
use Config\Email;
use Config\Services;

class Login extends BaseController
{
	private $viewpath = 'App\Modules\Login\Views\\';
	protected $session;

	public function __construct()
	{
		helper('alerts');
		$this->session = Services::session();
		$this->LoginRegisterModel = new LoginRegisterModel;
		$this->LoginRecoveryModel = new LoginRecoveryModel;
	}

	/**
	 * User login page
	 */
	public function index()
	{
		$isLoggedIn = $this->session->get('isLoggedIn');
		if($isLoggedIn == TRUE) {
			return redirect()->to(base_url('overview'));
		} else {
			$this->cachePage(0);
			$loginmodel = new LoginModel();
			$dataView['alerts'] = load_alerts($this->session);
			$this->template($this->viewpath, 'index', $dataView, FALSE, FALSE, FALSE); 
		}
	}

	/**
	 * Process user login
	 */
	public function process() {
		$data = array();
		$isUserValidate = FALSE;
		if($this->request->getMethod() == "post") {
			// Validate request
			$rules = [
				'emailaddress' => 'required',
				'password' => 'required|min_length[5]',
			];
			if(!$this->validate($rules)) {
				return redirect()->to(base_url())
					->withInput()
					->with('errors', $this->validator->getErrors());
			}

			// Try to login
			$loginmodel = new LoginModel();
			$check = $loginmodel->where('Email', $this->request->getPost('emailaddress'))->first();

			if(is_null($check) || !password_verify($this->request->getPost('password'), $check['Password'])) {
				return redirect()->to(base_url())->withInput()->with('error', 'Combinatie e-mailadres en wachtwoord onjuist, probeer het nog eens.');
			}

			// Check if user has sellers connected
			$model_sellerconnect = new SellerConnectModel();
			$checkSeller = $model_sellerconnect->check_seller($check['UsersKey']);
			if(is_array($checkSeller) && count($checkSeller) > 0) {
				$this->session->set('sellerData', $checkSeller);
			} else {
				return redirect()->to(base_url())->withInput()->with('error', 'Geen actieve sellers beschikbaar.');
			}

			if($check['Status'] == 'Unverified'){
				return redirect()->back()->with('error', 'You have to verify your email before you can log in.');
			}
			
			// Login OK Set sessie en cookies aan
			$this->session->set('isLoggedIn', true);
			$this->session->set('userData', [
				'UsersKey' => $check['UsersKey'],
				'FirstName'	=> $check['FirstName'],
				'LastName' => $check['LastName'],
				'Email' => $check['Email'],
				'Token' => $check['Token'],
				'FirstLogin' => $check['FirstLogin'],
			]); 

			if($check['Status'] == 'Active'){
				// Redirect to dashboard
				return redirect()->to(base_url('overview'));
			}elseif($check['Status'] == 'Recovery'){
				//IF USER HAS RECOVERED HIS PASSWORD HE WILL BE SENDED TO A FORM WHERE HE/SHE CAN UPDATE THEIR PASSWORD TO A PERSONAL PASSWORD.
				return redirect()->to(base_url('login/recovery'));
			}else{
				return redirect()->to(base_url('overview'));
			}
        }
	}

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		$this->session->remove(['isLoggedIn', 'userData', 'user_roles']);
		return redirect()->to(base_url('login'));
	}

	/**
	 * Forgot password
	 */
	public function forgotPassword_form(){		
		$dataView = array();
		$dataView['alerts'] = load_alerts($this->session);
		$this->template($this->viewpath, 'forgot_password_form', $dataView, FALSE, FALSE, FALSE); 
	}

	public function forgot_password()
	{
		// validate request
		if (! $this->validate(['emailaddress' => 'required|valid_email'])) {
            return redirect()->back()->with('error', 'E-mailadres onvolledig of niet ingevuld.');
        }

		// check if email exists in DB
		$loginmodel = new LoginModel();
		$check = $loginmodel->where('Email', $this->request->getPost('emailaddress'))->first();
		if(!$check) {
            return redirect()->back()->with('error', 'Er is geen gebruiker gevonden met dit e-mailadres.');
		}
		
		// set reset hash and expiration
		helper('text');
		$newTempPassword = random_string('alnum', 16);
		$updatedUser['UsersKey'] = $check['UsersKey'];
		$updatedUser['Status'] = "Recovery";
		$updatedUser['Token'] = random_string('alnum', 36);
		$updatedUser['Password'] = password_hash($newTempPassword, PASSWORD_DEFAULT);
		$loginmodel->save($updatedUser);

		// send password reset e-mail
		helper('email');
        $sendEmail = email_send_password_reset($this->request->getPost('emailaddress'), $newTempPassword);
		if($sendEmail == FALSE) {
			return redirect()->back()->with('error', 'E-mail versturen mislukt, probeer het later nog eens.');
		} else {
			return redirect()->back()->with('success', 'Je ontvangt een e-mail met daarin een tijdelijk nieuw wachtwoord.');
		}
	}

	/**
	 * Recovery 
	 */
	public function recovery() {
        $dataView['alerts'] = load_alerts(session());
        $this->template($this->viewpath, "password_recovery", $dataView, FALSE, FALSE, FALSE);
	}

	public function recovery_process() {
		// Get UsersKey from Session (userdata)	
		$formdata = $this->request->getPostGet();
		$UsersKey = $_SESSION['userData']['UsersKey'];
		$Token = $_SESSION['userData']['Token'];
		$data['user'] = $this->LoginRecoveryModel->getUsers($UsersKey, $Token);

		// Check password1 and password2 (must be the same)
		if(password_verify($formdata['new_password'], $data['user']['Password']) == TRUE){			
			// If all passed, update the users password (personal password) in DB
			if($formdata['Password'] == $formdata['Password2']){				
				$this->LoginRecoveryModel->update_recovery_password($formdata, $UsersKey, $Token);
			}else{				
				return redirect()->back()->with('error','The personal password does not match the verify password');
			}
			// Redirect to overview page with Flash data 'password recovered'
			return redirect()->to(base_url('overview'))->with('success','The recovered password has been updated!');			
		}else{
			
			return redirect()->back()->with('error','<a class="btn btn-danger text-white">The password does not match the password from email. Please check it and try again.</a>');
		}		
	}	

	/**
	 * Invite 
	 */
	public function invite($UsersKey, $Token, $SellersKey, $Type = 'accept')
	{
		$this->InviteModel = new InviteModel();
		$data = $this->InviteModel->process($UsersKey, $Token, $SellersKey, $Type);
		if(!is_array($data) || !isset($data['Type'])) {
			return redirect()->back()->with('error', 'Error during processing status, please try again.');
			exit();
		}

		$dataView['alerts'] = load_alerts($this->session);
		$dataView['data'] = $data;

		if($Type == "accept") {
			if($data['Type'] == "Firstlogin") {
				$this->template($this->viewpath, 'invite_new', $dataView, FALSE, FALSE, FALSE); 
			} else {
				return redirect()->to(base_url())->with('success', 'Invite accepted, you can now login to your Yeelt account and access the seller.');
			}
		} else {
			return redirect()->to(base_url())->with('info', 'Invite rejected, you can close this page.');
		}
	}

	/**
	 * Process invite 
	 */
	public function process_invite()
	{
		$formdata = $this->request->getPostGet();

		$this->InviteModel = new InviteModel();
		$this->InviteModel->process_invite($formdata);

		return redirect()->to(base_url())->with('success', 'Invite accepted and account created! You can now login to your Yeelt account and access the seller.');
	}

	/**
	 * Switch seller
	 */
	public function switch_seller()
	{
		$formdata = $this->request->getPostGet();
		$SellersKey = $formdata['switch_seller'];

		$model_sellerconnect = new SellerConnectModel();
		$checkSeller = $model_sellerconnect->check_seller_byid($SellersKey);
		if(is_array($checkSeller) && count($checkSeller) > 0) {
			$this->session->set('sellerData', $checkSeller);
			return redirect()->back();
		} else {
			return redirect()->back()->with('error', 'Could not make the switch.');
		}
	}

	public function register_form()
	{	
		$dataView = array();	
		$dataView['alerts'] = load_alerts($this->session);
		$this->template($this->viewpath, 'register', $dataView, FALSE, FALSE, FALSE); 
	
	}

	public function register_proccess(){
		$formdata = $this->request->getPostGet();
		$mail = $this->LoginRegisterModel->checkUserEmail($formdata['emailaddress']);

		$rules = [
			'emailaddress' => 'valid_email',
			'password'  => 'min_length[5]|max_length[25]',
			'password2' => 'min_length[5]|max_length[25]',
		];

		if(!$this->validate($rules)) {
			return redirect()->back()->with('errors', $this->validator->getErrors());
		}else{
			if($mail !== NULL){			
				return redirect()->back()->with('error', '<a class="btn btn-danger text-white">There is a user found with this e-mailaddress. Try another e-mailaddress.</a>');
			}else{
				if($formdata['password'] == $formdata['password2'])
				{		
					helper('email');					
					$userData = $this->LoginRegisterModel->create_user($formdata);
					$token = $userData['Token'];
					$sendEmail = email_send_verify_email($this->request->getPost('emailaddress'), $token);

					if($sendEmail == FALSE) {
						return redirect()->back()->with('error', '<a class="btn btn-danger text-white">Failed to send email, please try again later.</a>');
					} else {						
						return redirect()->back()->with('success', 'U will receive an email with an email confirmation link and with further information.');
					}					
				}else{
					return redirect()->back()->with('error', '<a class="btn btn-danger text-white">Both passwords don\'t match each other.</a>');
				}
			}
		}			
	}

	public function emailverified($Emailaddress, $token){
		$this->LoginRegisterModel->emailVerified($Emailaddress, $token);
		return redirect()->to(base_url('login'))->with('success','You can now log in!');
	}

	/**
	 * Bol Callback
	 */
	public function bolcallback()
	{
		$json = ['statis' => 'OK', 'callback' => 'bol'];
		echo json_encode($json);
	}
}
