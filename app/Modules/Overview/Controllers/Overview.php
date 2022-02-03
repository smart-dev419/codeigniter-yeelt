<?php namespace App\Modules\Overview\Controllers;

use App\Controllers\BaseController;
use App\Modules\Overview\Models\OverviewModel;

class Overview extends BaseController
{
    private $viewpath = 'App\Modules\Overview\Views\\';
    private $model;

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');

        $this->model = new OverviewModel();
    }
    
    /**
     * Dashboard
     */
    public function index($category = '', $level = 0)
	{
        $dataView['assets']['css'][] = site_url('theme/assets/css/libs/daterangepicker.css');

        $dataView['assets']['js'][] = site_url('theme/assets/js/libs/moment.js');
        $dataView['assets']['js'][] = site_url('theme/assets/js/libs/daterangepicker.min.js');

        $dataView['assets']['js'][] = 'https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js';
        $dataView['assets']['js'][] = 'https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes';

        $dataView['assets']['js'][] = site_url('theme/assets/js/overview.js');

        $dataView['alerts'] = load_alerts(session());
        
        $dataView['category'] = $category;
        $dataView['level'] = $level;
        $this->template($this->viewpath, "overview", $dataView);
	}

    /**
     * Get all stats for the overview page
     */
    public function stats()
	{
        $formdata = $this->request->getPostGet();
        $data['Metrics'] = $this->model->get_Metrics($formdata);
        $data['Metrics_Products'] = $this->model->get_Metrics_Products($formdata);
        $data['Charts']['RevenueSales'] = $this->model->get_ChartRevenueSales($formdata);
        echo json_encode($data);
	}

}
