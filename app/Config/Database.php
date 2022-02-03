<?php namespace Config;

/**
 * Database Configuration
 *
 * @package Config
 */

class Database extends \CodeIgniter\Database\Config
{
	/**
	 * The directory that holds the Migrations
	 * and Seeds directories.
	 *
	 * @var string
	 */
	public $filesPath = APPPATH . 'Database/';

	/**
	 * Lets you choose which connection group to
	 * use if no other is specified.
	 *
	 * @var string
	 */
	public $defaultGroup = 'default';

	/**
	 * The default database connection.
	 * DBL HUB Database for CORE application database
	 *
	 * @var array
	 */
	public $default = [
		'DSN'      => '',
		'hostname' => '',
		'username' => '',
		'password' => '',
		'database' => '',
		'DBDriver' => 'sqlsrv',
		'DBPrefix' => '',
		'pConnect' => true,
		'DBDebug'  => (ENVIRONMENT !== 'production'),
		'cacheOn'  => false,
		'cacheDir' => '',
		'charset'  => 'utf8',
		'DBCollat' => 'utf8_general_ci',
		'swapPre'  => '',
		'encrypt'  => false,
		'compress' => false,
		'strictOn' => false,
		'failover' => [],
		'port'     => 3306,
	];

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		# Default
		$this->default['hostname'] = getenv('DB_DEFAULT_HOST');
		$this->default['database'] = getenv('DB_DEFAULT_DB');
		$this->default['username'] = getenv('DB_DEFAULT_USER');
		$this->default['password'] = getenv('DB_DEFAULT_PASS');
	}

	//--------------------------------------------------------------------

}
