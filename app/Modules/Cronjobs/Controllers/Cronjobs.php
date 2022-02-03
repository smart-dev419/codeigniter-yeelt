<?php namespace App\Modules\Cronjobs\Controllers;

use App\Controllers\BaseController;
use App\Modules\Cronjobs\Models\CronjobsModel;

class Cronjobs extends BaseController
{
    private $viewpath = 'Applications\Cronjobs\Actions\Views\\';
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
     * Dashboard
     */
    public function actions1()
	{
        echo 'Actions1';
	}

}
