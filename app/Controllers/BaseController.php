<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use App\Models\GlobalModel;
use CodeIgniter\Controller;
use Config\Services;

class BaseController extends Controller
{
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$session = Services::session();
		$language = Services::language();
		if(!isset($session->lang)) {
			$session->set('lang', 'en');
		}
		$language->setLocale($session->lang);

		$this->globalModel = new GlobalModel();
	}

	/**
	 * Load templates with different options
	 * Path is used to determinate wich of the modules/views must be loaded
	 *
	 * @param string $path
	 * @param string $page
	 * @param array $data <- main view data
	 * @param boolean $menu <- sidebar for each module
	 * @param boolean $header
	 * @param boolean $footer
	 * @return void
	 */
	public function template(string $path, string $page, array $data, bool $menu = TRUE, bool $header = TRUE, bool $footer = TRUE)
	{
		$menudata['seller_choices'] = $this->globalModel->get_seller_accounts();

		if($header == TRUE) echo view('template/header', $data);
		if($menu == TRUE) echo view('template/menu', array_merge($data, $menudata));
		echo view($path.$page, $data);
		if($footer == TRUE) echo view('template/footer', $data);
	}
}
