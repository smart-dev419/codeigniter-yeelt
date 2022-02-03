<?php 
namespace App\Modules\Settings\Models;

use CodeIgniter\Model;
use App\Libraries\BolRetailer;

class SettingsModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function get_seller()
    {
        return $this->db->table('Sellers')
                    ->where(['SellersKey' => $_SESSION['sellerData']['SellersKey']])
                    ->get()
                    ->getRowArray();
    }

    public function process_profile($formdata)
    {
        // Get current seller data from database
        $data_seller = $this->get_seller();

        $update = array();
        $update['SellerID'] = $formdata['SellerID'];
        $update['Name'] = $formdata['Name'];

        $update['ApiClientID'] = $formdata['ApiClientID'];
        $update['ApiClientSecret'] = $formdata['ApiClientSecret'];

        if( ($data_seller['ApiClientID'] !== $formdata['ApiClientID']) || ($data_seller['ApiClientSecret'] !== $formdata['ApiClientSecret']) ) {
            // Get Bol.com access token
            $bolapi_retailer = new BolRetailer();
            $auth = $bolapi_retailer->getAuth($formdata['ApiClientID'], $formdata['ApiClientSecret']);
            if($auth !== FALSE && isset($auth['access_token'])) {
                $update['ApiClientToken'] = $auth['access_token'];
                $update['ApiClientTokenExpireTime'] = $auth['expires_at'];
            } else {
                $update['ApiClientToken'] = "";
                $update['ApiClientTokenExpireTime'] = "";
            }
        }

        return $this->db->table('Sellers')
                    ->where('SellersKey', $_SESSION['sellerData']['SellersKey'])
                    ->update($update);
    }
    
    public function get_users()
    {
        return $this->db->table('UsersSellers as us')
        ->where(['us.SellersKey' => $_SESSION['sellerData']['SellersKey']])
        ->join('Users as u', 'u.UsersKey = us.UsersKey')
        ->get()
        ->getResultArray();
    }
    
    /**
     * Process the invite of a user
     *  
     * @param array $formdata
     * @return void
     */
    public function process_invite($formdata)
    {
        helper('global');
        $return = array();

        // Emailaddress validation
        $emailaddress = $formdata['Emailaddress'];

        // Check if user exists in database
        // Create user in database if not exists
        // countResultAll - numrows
        $user_data = $this->db->table('Users')->where(['Email' => $emailaddress])->get()->getRowArray();
        if($user_data !== FALSE && isset($user_data['UsersKey'])) {
            $UsersKey = $user_data['UsersKey'];
            $return['exists'] = TRUE;
            $return['password'] = "";
        } else {
            $return['exists'] = FALSE;
            $return['password'] = randomString(16);
            $return['Token'] = randomString(36);

            $insert = array();
            $insert['Email'] = $emailaddress;
            $insert['Token'] = $return['Token'];
            $insert['Type'] = 'Firstlogin';
            $insert['Password'] = password_hash($return['password'], PASSWORD_DEFAULT);
            $insert['DateTimeCreate'] = date("Y-m-d H:i:s");
            $insert['DateTimeUpdate'] = date("Y-m-d H:i:s");
            $insert['FirstName'] = "";
            $insert['LastName'] = "";
            $this->db->table('Users')->insert($insert);
            $UsersKey = $this->db->insertID();
        }

        // Connect User to Seller if not exists
        $user_connect = $this->db->table('UsersSellers')->where(['UsersKey' => $UsersKey, 'SellersKey' => $_SESSION['sellerData']['SellersKey']])->get()->getRowArray();
        if($user_connect == FALSE) {
            $insert = array();
            $insert['UsersKey'] = $UsersKey;
            $insert['SellersKey'] = $_SESSION['sellerData']['SellersKey'];
            $insert['AcceptedBySeller'] = 1;
            $insert['AccessType'] = 0;
            $insert['AcceptedByUser'] = 0;
            $insert['Primary'] = 0;
            $this->db->table('UsersSellers')->insert($insert);
        }

        $return['UsersKey'] = $UsersKey;
        $return['SellersKey'] = $_SESSION['sellerData']['SellersKey'];
        $return['SellerData'] = $this->get_seller();

        return $return;
    }

    /**
     * Delete a user
     */
    public function delete($UsersKey, $Token)
    {
        $user_connect = $this->db->table('UsersSellers')->where(['UsersKey' => $UsersKey, 'SellersKey' => $_SESSION['sellerData']['SellersKey']])->get()->getRowArray();
        if($user_connect !== FALSE) {
            $this->db->table('UsersSellers')->delete(['UsersKey' => $UsersKey, 'SellersKey' => $_SESSION['sellerData']['SellersKey']]);

            $user_data = $this->db->table('Users')->where(['UsersKey' => $UsersKey, 'Token' => $Token])->get()->getRowArray();
            if($user_data !== FALSE) {
                if($user_data['Type'] == "Firstlogin") {
                    $this->db->table('Users')->delete(['UsersKey' => $UsersKey, 'Token' => $Token]);
                }
            }
        }
    }

    public function update_logo($newName){               
        $db_data['Logo'] = $newName;
        $this->db->table('Sellers')->where(['SellersKey' => $_SESSION['sellerData']['SellersKey']])->update($db_data);
        
        $_SESSION['sellerData']['Logo'] = $db_data['Logo'];       

        return true;
    }
}
