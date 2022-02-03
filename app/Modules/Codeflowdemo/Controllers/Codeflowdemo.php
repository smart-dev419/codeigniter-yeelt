<?php namespace App\Modules\Codeflowdemo\Controllers;

use App\Controllers\BaseController;

use Config\Email;
use Config\Services;

class Codeflowdemo extends BaseController
{
	private $viewpath = 'App\Modules\Codeflowdemo\Views\\';
	protected $session;

	public function __construct()
	{
		helper('alerts');
		$this->session = Services::session();
	}

	/**
	 * Code Flow Demo
	 */
	public function index() {
		$this->template($this->viewpath, "index", []);
	}

	/**
	 * Code Flow OUT
	 */
	public function out() {
		$url_auth = 'https://login.bol.com/authorize';
        $url_token = 'https://login.bol.com/token';

        $clientID = '2f73c65d-99ee-48a8-8894-142f88c4333c';
        $clientSecret = '4D2E!yN]mLf%aCIwuPUsO5bj[[kB!DQE?jd(!D8dujV9eSk__lUaWsfO-cnd+VTx';
        $callbackURL = 'http://localhost/yeelt/codeflowdemo/out';

        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $clientID,
            'clientSecret'            => $clientSecret,
            'redirectUri'             => $callbackURL,
            'urlAuthorize'            => $url_auth,
            'urlAccessToken'          => $url_token,
            'urlResourceOwnerDetails' => '',
            'scopes'                  => ['offline_access'],
        ]);
        if (!isset($_GET['code'])) {
            $authorizationUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authorizationUrl);
            exit;
        } elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {
            if (isset($_SESSION['oauth2state'])) {
                unset($_SESSION['oauth2state']);
            }
            exit('Invalid state');
        } else {
            try {
                $code = $_GET['code'];
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $code
                ]);

                $db_accesstoken = $accessToken->getToken();
                $db_refreshtoken = $accessToken->getRefreshToken();
                $db_expires = $accessToken->getExpires();
                $db_expired = ($accessToken->hasExpired() ? 'expired' : 'not expired');

                echo 'Access Token: ' . $accessToken->getToken() . "<br>";
                echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
                echo 'Expired in: ' . ($accessToken->getExpires() - time()) . "<br>";
                echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";
                
                /* / Token to JSON data
                $json = $accessToken->jsonSerialize();

                // Check token
                $token_check = new \League\OAuth2\Client\Token\AccessToken($json);

                $dbtoken = array();
                $dbtoken['json_data'] = json_encode($json);
                $dbtoken['access_token'] = $db_accesstoken;
                $dbtoken['refresh_token'] = $db_refreshtoken;
                $dbtoken['expires'] = $db_expires;
                $this->db->insert("users_authtokens", $dbtoken);*/
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                exit($e->getMessage());
            }
        }
	}
}
