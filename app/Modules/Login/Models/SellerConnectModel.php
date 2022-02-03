<?php 
namespace App\Modules\Login\Models;
use CodeIgniter\Model;

class SellerConnectModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function check_seller($UsersKey) {
        return $this->db->table('UsersSellers as us')
                    ->where(['UsersKey' => $UsersKey])
                    ->where(['AcceptedBySeller' => 1])
                    ->where(['Primary' => 1])
                    ->join('Sellers as s', 's.SellersKey = us.SellersKey')
                    ->get()
                    ->getRowArray();
    }

    public function check_seller_byid($SellersKey) {
        return $this->db->table('UsersSellers as us')
                    ->where(['UsersKey' => $_SESSION['userData']['UsersKey']])
                    ->where(['us.SellersKey' => $SellersKey])
                    ->where(['AcceptedBySeller' => 1])
                    ->join('Sellers as s', 's.SellersKey = us.SellersKey')
                    ->get()
                    ->getRowArray();
    }
}