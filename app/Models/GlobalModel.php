<?php 
namespace App\Models;
use CodeIgniter\Model;

class GlobalModel
{
    protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function get_seller_accounts()
    {
        if(isset($_SESSION['userData']) && isset($_SESSION['userData']['UsersKey'])) {
            $UsersKey = $_SESSION['userData']['UsersKey'];
            return $this->db->table('UsersSellers as us')
                        ->where(['UsersKey' => $UsersKey])
                        ->where(['AcceptedBySeller' => 1])
                        ->join('Sellers as s', 's.SellersKey = us.SellersKey')
                        ->get()
                        ->getResultArray();
        }
    }
    
}