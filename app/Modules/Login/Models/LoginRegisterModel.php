<?php 
namespace App\Modules\Login\Models;
use CodeIgniter\Model;

class LoginRegisterModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getUsers($UsersKey, $Token){
        return $this->db->table('Users')
                        ->get()
                        ->getRowArray();
    }

    public function checkUserEmail($Emailaddress){
        return $this->db->table('Users')  
                    ->where(['Email' => $Emailaddress])                  
                    ->get()
                    ->getRowArray();
    }

    public function create_user($formdata){
        helper('global');
        $db_data['FirstName'] = $formdata['firstname'];
        $db_data['LastName'] = $formdata['lastname'];
        $db_data['Email'] = $formdata['emailaddress'];
		$db_data['Password'] = password_hash($formdata['password'], PASSWORD_DEFAULT);
        $db_data['Token'] = randomString(32);
        $db_data['Type'] = 'Regular';
        $db_data['Status'] = 'Unverified';
        $db_data['FirstLogin'] = 1;
        
        // User aanmaken
        $this->db->table('Users')->insert($db_data);
        $UsersKey = $this->db->insertID();

        // Seller aanmaken
        $seller_data['Token'] = randomString(32);
        $this->db->table('Sellers')->insert($seller_data);
        $SellersKey = $this->db->insertID();

        // Connectie tabel regel aanmaken
        $db_connectie['UsersKey'] = $UsersKey;
        $db_connectie['SellersKey'] = $SellersKey;
        $db_connectie['AcceptedBySeller'] = 1;
        $db_connectie['AccessType'] = 0;
        $db_connectie['AcceptedByUser'] = 1;
        $db_connectie['Primary'] = 1;
        $this->db->table('UsersSellers')->insert($db_connectie);

        return $db_data;
    }

    public function emailVerified($Emailaddress, $token){
        $db_data['Status'] = 'Active';
        $this->db->table('Users')->where(['Email' => $Emailaddress, 'Token' => $token])->update($db_data);
    }
}