<?php 
namespace App\Modules\Login\Models;

use CodeIgniter\Model;

class LoginRecoveryModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Gets all the columns from Users Table
    public function getUsers($UsersKey, $Token){
        return $this->db->table('Users')
                    ->where(['UsersKey' => $UsersKey, 'Token' => $Token])
                    ->get()
                    ->getRowArray();
    }

    //Function to update the new recovered password to personal password.
    public function update_recovery_password($formdata, $UsersKey, $Token)
    {       
        $Password = password_hash($formdata['Password'], PASSWORD_DEFAULT);
        $db_data['Password'] = $Password;
        $db_data['Status'] = 'Active';      
        $this->db->table('Users')->where(['UsersKey' => $UsersKey, 'Token' => $Token])->update($db_data);
                
    }
    
}