<?php 
namespace App\Modules\Welcome\Models;
use CodeIgniter\Model;

class WelcomeModel
{
	protected $db;
    public function __construct($dbinfo)
    {
        $this->db = \Config\Database::connect($dbinfo);
    }
    
}