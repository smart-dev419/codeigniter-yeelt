<?php 
namespace Applications\Cronjobs\Actions\Models;
use CodeIgniter\Model;

class ActionsModel
{
	protected $db;
    public function __construct($dbinfo)
    {
        $this->db = \Config\Database::connect($dbinfo);
    }
    
}