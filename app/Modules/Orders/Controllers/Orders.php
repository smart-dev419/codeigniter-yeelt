<?php namespace App\Modules\Orders\Controllers;

use App\Controllers\BaseController;
use App\Modules\Orders\Models\OrdersModel;

class Orders extends BaseController
{
    private $viewpath = 'App\Modules\Orders\Views\\';
    private $model;

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');
        helper('core');
        $this->OrdersModel = new OrdersModel();
    }
    
    /**
     * Function
     */
    public function list()
	{
        $dataView['alerts'] = load_alerts(session());
        $dataView['orders'] = $this->OrdersModel->orders_findAll();
        $this->template($this->viewpath, "list", $dataView);
	}

    /**
     * Function
     */
    public function data($OrderID)
	{
        $dataView['alerts'] = load_alerts(session());
        $dataView['data'] = $this->OrdersModel->orders_find($OrderID);
        $this->template($this->viewpath, "data", $dataView);
	}

}
