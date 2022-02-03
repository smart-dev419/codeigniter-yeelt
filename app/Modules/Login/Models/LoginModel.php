<?php 
namespace App\Modules\Login\Models;
use CodeIgniter\Model;

class LoginModel extends Model
{
	protected $table = 'Users';
	protected $primaryKey = 'UsersKey';
	protected $useTimestamps = true;
	protected $useSoftDeletes = false;
	protected $returnType = 'array';
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;

	// Timestamp fields
	protected $createdField = 'DateTimeCreate'; 
	protected $updatedField = 'DateTimeUpdate'; 	
	
	// this happens first, model removes all other fields from input data
	protected $allowedFields = [
		'emailaddress', 'password',
		'Status', 'ResetToken', 'Password',
		'UsersGroupsKey',
	];

    // this runs after field validation
	protected $beforeInsert = ['hashPassword'];
	protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
	{
		if (!isset($data['data']['password'])) return $data;

		$data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
		unset($data['data']['password']);
		unset($data['data']['password_confirm']);

		return $data;
	}

	public function getUserDB($emailadres, $userPrincipalName = '') {
		if(empty($emailadres)) {
			$emailadres = $userPrincipalName;
		}

		$builder = $this->db->table('Users')
						->where('Email', $emailadres);
        $query = $builder->get();
        return $query->getRowArray();
	}

}