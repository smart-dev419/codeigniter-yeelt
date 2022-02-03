<?php namespace App\Modules\Subscription\Controllers;

use App\Controllers\BaseController;
use App\Modules\Subscription\Models\SubscriptionModel;

class Subscription extends BaseController
{
    private $viewpath = 'App\Modules\Subscription\Views\\';
    private $model;

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');

        $this->SubscriptionModel = new SubscriptionModel();
    }
    
    /**
     * Function
     */
    public function index()
	{
        helper('global');
        
        $dataView['data'] = $this->SubscriptionModel->read();
        $dataView['alerts'] = load_alerts(session());
        $this->template($this->viewpath, "index", $dataView);
	}

}
