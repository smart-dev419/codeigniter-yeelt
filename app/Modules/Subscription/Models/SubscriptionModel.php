<?php 
namespace App\Modules\Subscription\Models;
use CodeIgniter\Model;

class SubscriptionModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Get active subscription from the database
     *
     * @return array
     */
    public function read() {
        return $this->db->query("SELECT * FROM [dbo].[SellersSubscription] WHERE SellersKey = '".$_SESSION['sellerData']['SellersKey']."'")->getRowArray();
    }
    
}