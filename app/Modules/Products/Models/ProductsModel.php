<?php 
namespace App\Modules\Products\Models;
use CodeIgniter\Model;

class ProductsModel
{
	protected $db;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Get all products from the database
     *
     * @return array
     */
    public function products_findAll() {
        return $this->db->query("SELECT * FROM [dbo].[Products] as p
                    JOIN (
                            SELECT 
                                MAX(OpenDataMutationKey) max_id, Ean
                            FROM 
                                ProductsOpenDataMutations 
                            GROUP BY
                                Ean
                        ) as pm 
                    ON 
                        p.Ean = pm.Ean
                    JOIN      
                        ProductsOpenDataMutations as data_pm ON (data_pm.OpenDataMutationKey = pm.max_id)
                    WHERE p.SellersKey = '".$_SESSION['sellerData']['SellersKey']."'")->getResultArray();
    }
    
}