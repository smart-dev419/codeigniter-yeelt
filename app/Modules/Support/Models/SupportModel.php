<?php 
namespace App\Modules\Products\Models;
use CodeIgniter\Model;

class ProductsModel
{
	protected $db;
    public function __construct($dbinfo)
    {
        $this->db = \Config\Database::connect($dbinfo);
    }
    
}