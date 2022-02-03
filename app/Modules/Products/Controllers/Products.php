<?php namespace App\Modules\Products\Controllers;

use App\Controllers\BaseController;
use App\Modules\Products\Models\ProductsModel;

class Products extends BaseController
{
    private $viewpath = 'App\Modules\Products\Views\\';
    private $model;

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');
        $this->ProductsModel = new ProductsModel();
    }
    
    /**
     * Function
     */
    public function list()
	{
        $dataView['alerts'] = load_alerts(session());
        $dataView['products'] = $this->ProductsModel->products_findAll();
        $this->template($this->viewpath, "list", $dataView);
	}

}
