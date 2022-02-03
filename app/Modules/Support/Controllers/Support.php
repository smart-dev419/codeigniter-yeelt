<?php namespace App\Modules\Support\Controllers;

use App\Controllers\BaseController;
use App\Modules\Support\Models\SupportModel;

class Support extends BaseController
{
    private $viewpath = 'App\Modules\Support\Views\\';
    private $model;

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');
    }
    
    /**
     * Function
     */
    public function index()
	{
        $dataView['alerts'] = load_alerts(session());
        $this->template($this->viewpath, "index", $dataView);
	}

}
