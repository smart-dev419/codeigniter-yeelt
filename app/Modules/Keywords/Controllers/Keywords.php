<?php namespace App\Modules\Keywords\Controllers;

use App\Controllers\BaseController;
use App\Modules\Keywords\Models\KeywordsModel;
use App\Libraries\BolRetailer;
use Config\Services;

class Keywords extends BaseController
{
    private $viewpath = 'App\Modules\Keywords\Views\\';
    private $model;

    /**
     * Constructor that is being called after BaseController construct
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('alerts');
        helper('core');

        $this->KeywordsModel = new KeywordsModel();
        $this->session = Services::session();
    }
    
    /**
     * Function
     */
    public function list()
	{
        $dataView['alerts'] = load_alerts(session());
        $dataView['keywords'] = $this->KeywordsModel->keywords_findAll();
        $dataView['num_suggestions'] = count($this->KeywordsModel->suggestions_findAll());
        $this->template($this->viewpath, "list", $dataView);
	}

    /**
     * Function
     */
    public function delete($id, $token)
	{
        $this->KeywordsModel->delete_keyword($id, $token);
        return redirect()->to(base_url('keywords/list'))->with('success', 'Keyword is deleted.');
	}

    /**
     * Function
     */
    public function suggestions()
	{
        $dataView['suggestions'] = $this->KeywordsModel->suggestions_findAll();
        $dataView['alerts'] = load_alerts(session());
        $this->template($this->viewpath, "suggestions", $dataView);
	}

    /**
     * Function
     */
    public function add_suggestion($id, $token)
	{
        $this->KeywordsModel->add_suggestion($id, $token);
        return redirect()->to(base_url('keywords/suggestions'))->with('success', 'Keyword suggestion is added to your tracking list.');
	}

     /**
     * Function
     */
    public function add()
	{
        $dataView = array();
        $this->template($this->viewpath, "add_index", $dataView);
	}

     /**
     * Function
     */
    public function volumes()
	{
        $dataView['assets']['js'][] = site_url('theme/assets/modules/keywords/volume.js');
        
        $formdata = $this->request->getPostGet();
        if(!isset($formdata['keywords']) || (isset($formdata['keywords']) && ltrim(rtrim($formdata['keywords'])) == '')) {
            return redirect()->to(base_url('keywords/add'));
            exit();
        }
        
        $dataView['keywords'] = $formdata;
        $this->template($this->viewpath, "add_volumes", $dataView);
	}

    /**
     * Function
     */
    public function get_volumes()
	{
        $formdata = $this->request->getPostGet();
        if(isset($formdata['keyword'])) {
            $bolapi_retailer = new BolRetailer();
            $auth = $bolapi_retailer->getAuth();
            $search_terms = $bolapi_retailer->search_terms($formdata['keyword'], 'DAY', 30, true);

            $suggestions = array();
            if(isset($search_terms['searchTerms']['relatedSearchTerms'])) {
                $suggestions = $search_terms['searchTerms']['relatedSearchTerms'];
            }

            echo json_encode(array(
                'total' => $search_terms['searchTerms']['total'],
                'related' => $suggestions,
            ));            
        }
	}

    /**
     * Function
     */
    public function add_process()
	{
        $formdata = $this->request->getPostGet();
        $added = $this->KeywordsModel->process_keywords($formdata);
        $this->session->setFlashdata('keywordtool_added', $added);

        return redirect()->to(base_url('keywords/add_result'));
	}

    /**
     * Function
     */
    public function add_result()
	{
        $dataView['added'] = $this->session->getFlashdata('keywordtool_added');

        if($dataView['added'] == "") {
            return redirect()->to(base_url('keywords/add'));
            exit();
        }

        $this->template($this->viewpath, "add_result", $dataView);
	}

}
