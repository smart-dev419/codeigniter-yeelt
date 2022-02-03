<?php 
namespace App\Modules\Orders\Models;
use CodeIgniter\Model;

class OrdersModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Get all keywords from the database
     *
     * @return array
     */
    public function orders_findAll() {
        return $this->db->query("SELECT o.OrderID, o.DateTimePlaced, SUM(UnitPrice) as Total, SUM(Commission) as Commision, COUNT(oi.OrderItemID) as NumProducts FROM [dbo].[SellerOrders] as o
                        JOIN [dbo].[SellerOrdersItems] as oi ON o.OrderID = oi.OrderID
                        WHERE SellersKey = '".$_SESSION['sellerData']['SellersKey']."'
                        GROUP BY o.OrderID, o.DateTimePlaced"
                    )
                    ->getResultArray();
    }

    /**
     * Get all keywords from the database
     *
     * @return array
     */
    public function orders_find($OrderID) {
        return $this->db->query("SELECT * FROM [dbo].[SellerOrders] as o
                        JOIN [dbo].[SellerOrdersItems] as oi ON o.OrderID = oi.OrderID
                        WHERE o.SellersKey = '".$_SESSION['sellerData']['SellersKey']."'
                        AND o.OrderID = '".$OrderID."'"
                    )
                    ->getResultArray();
    }
    
}