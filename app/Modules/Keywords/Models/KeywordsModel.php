<?php 
namespace App\Modules\Keywords\Models;
use CodeIgniter\Model;

class KeywordsModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Get all keywords from the database
     *
     * @return array
     */
    public function keywords_findAll() {
        return $this->db->table('Keywords')
                    ->where(['SellersKey' => $_SESSION['sellerData']['SellersKey']])
                    ->orderBy('Keyword')
                    ->get()
                    ->getResultArray();
    }

    /**
     * Get all suggestions from the database
     *
     * @return array
     */
    public function suggestions_findAll() {
        return $this->db->table('KeywordsSuggestions')
                    ->where(['SellersKey' => $_SESSION['sellerData']['SellersKey']])
                    ->orderBy('Volume', 'DESC')
                    ->get()
                    ->getResultArray();
    }
    
    /**
     * Insert all the keywords that comes from the post data
     *
     * @param array $formdata
     * @return int
     */
    public function process_keywords($formdata)
    {
        $added = 0;

        if(isset($formdata['keywords']) && is_array($formdata['keywords']))
        {
            foreach($formdata['keywords'] as $keyword) :
                $insert = $this->insert_keyword($keyword);
                if($insert == TRUE) {
                    $added++;
                }
            endforeach;
        }  

        if(isset($formdata['suggestions']) && is_array($formdata['suggestions']))
        {
            foreach($formdata['suggestions'] as $keyword) :
                $insert = $this->insert_keyword($keyword, 1);
                if($insert == TRUE) {
                    $added++;
                }
            endforeach;
        }  
        
        return $added;
    }

    /**
     * Convert keyword and insert if not exists
     *
     * @param string $keyword
     * @param integer $suggested
     * @return bool
     */
    public function insert_keyword($keyword, $suggested = 0) {
        $keyword = preg_replace("/[^A-Za-z0-9'_ ]/", '', $keyword);
        $keyword = strtolower($keyword);
        $keyword = rtrim($keyword);
        $keyword = ltrim($keyword);

        if(!empty($keyword))
        {
            $insert = array();
            $insert['Keyword'] = $keyword;
            $insert['SellersKey'] = $_SESSION['sellerData']['SellersKey'];
            $insert['DateTimeCreate'] = date("Y-m-d H:i:s");
            $insert['DateTimeUpdate'] = date("Y-m-d H:i:s");
            $insert['Suggested'] = $suggested;

            $count = $this->db->table('Keywords')
                            ->where([
                                'Keyword' => $keyword,
                                'SellersKey' => $_SESSION['sellerData']['SellersKey'],
                                ])
                            ->countAllResults();

            if($count == 0) {
                $this->db->table('Keywords')->insert($insert);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

     /**
     * Delete a keyword
     */
    public function delete_keyword($id, $token)
    {
        $this->db->table('Keywords')->delete(['KeywordKey' => $id, 'Token' => $token, 'SellersKey' => $_SESSION['sellerData']['SellersKey']]);
		return TRUE;
    }

     /**
     * Adds a suggestion to main keyword list
     */
    public function add_suggestion($id, $token)
    {
        # Place where conditions in variable to use in multiple queries
        $where_suggestion = ['KeywordsSuggestionsKey' => $id, 'Token' => $token, 'SellersKey' => $_SESSION['sellerData']['SellersKey']];

        $suggestion = $this->db->table('KeywordsSuggestions')->where($where_suggestion)->get()->getRowArray();
        if(is_array($suggestion) && count($suggestion) > 0 && isset($suggestion['Keyword'])) {
            # Check if suggestion already exists in seller account
            $get_keyword = $this->db->table('Keywords')->where(['Keyword' => $suggestion['Keyword'], 'SellersKey' => $_SESSION['sellerData']['SellersKey']])->get()->getRowArray();
            if($get_keyword == NULL) {
                $insert['Keyword'] = $suggestion['Keyword'];
                $insert['SellersKey'] = $_SESSION['sellerData']['SellersKey'];
                $insert['DateTimeCreate'] = date("Y-m-d H:i:s");
                $insert['DateTimeUpdate'] = date("Y-m-d H:i:s");
                $insert['Suggested'] = 0;
                $this->db->table('Keywords')->insert($insert);
            }

            # Delete suggestion, no longer needed
            $this->db->table('KeywordsSuggestions')->delete($where_suggestion);
        }
        
		return TRUE;
    }
}