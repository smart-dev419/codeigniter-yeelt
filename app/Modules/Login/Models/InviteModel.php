<?php 
namespace App\Modules\Login\Models;
use CodeIgniter\Model;

class InviteModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function process($UsersKey, $Token, $SellersKey, $Type = 1)
    {
        if($Type == 'accept') {
            $accepted_status = 1;
        } elseif($Type == 'reject') {
            $accepted_status = 2;
        }

        $data = $this->db->table('Users')->where(['UsersKey' => $UsersKey, 'Token' => $Token])->get()->getRowArray();
        if($Type == 'reject' || $Type == 'accept') {
            if($data !== FALSE) {
                $update = array();
                $update['AcceptedByUser'] = $accepted_status;
                $update['Primary'] = "0";
                $this->db->table('UsersSellers')->where(['UsersKey' => $UsersKey, 'SellersKey' => $SellersKey])->update($update);
            }
        }

        return $data;
    }

    public function process_invite($formdata)
    {
        $data = $this->db->table('Users')->where(['UsersKey' => $formdata['UID'], 'Token' => $formdata['TOK'], 'Email' => $formdata['EMAIL']])->get()->getRowArray();
        if($data !== FALSE) {
            $update = array();
            $update['Type'] = 'Regular';
            $update['FirstName'] = $formdata['firstname'];
            $update['LastName'] = $formdata['lastname'];
            $update['Password'] = password_hash($formdata['password'], PASSWORD_DEFAULT);
            $this->db->table('Users')->where(['UsersKey' => $formdata['UID'], 'Token' => $formdata['TOK'], 'Email' => $formdata['EMAIL']])->update($update);
        }
        return $data;
    }
}