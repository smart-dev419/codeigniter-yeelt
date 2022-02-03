<?php 
namespace App\Modules\Account\Models;
use CodeIgniter\Model;

class AccountModel
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function get_user()
    {
        return $this->db->table('Users')
                    ->where(['UsersKey' => $_SESSION['userData']['UsersKey']])
                    ->get()
                    ->getRowArray();
    }

    public function get_sellers(){
        return$this->db->table('Sellers')
                        ->where(['SellersKey' => $_SESSION['sellerData']['SellersKey']])
                        ->get()
                        ->getRowArray();
    }

    public function process_account($formdata)
    {
        $update = array();
        $update['FirstName'] = $formdata['FirstName'];
        $update['LastName'] = $formdata['LastName'];

        if(!empty($formdata['Password']) && ($formdata['Password'] == $formdata['PasswordConfirm'])) {
            $update['Password'] = password_hash($formdata['Password'], PASSWORD_DEFAULT);
            $this->db->table('Users')
                    ->where('UsersKey', $_SESSION['userData']['UsersKey'])
                    ->update($update);
            
            return FALSE;
        } else {
            $this->db->table('Users')
                    ->where('UsersKey', $_SESSION['userData']['UsersKey'])
                    ->update($update);

            return TRUE;
        }         
    }

    public function create_seller($formdata, $newName){
        $db_data['SellerID'] = $formdata['seller_id'];
        $db_data['Name'] = $formdata['name'];
		$db_data['ApiClientID'] = $formdata['api_client_id'];       
        $db_data['ApiClientSecret'] = $formdata['api_client_secret'];       
        $db_data['Logo'] = $newName;
        $this->db->table('Sellers')->where(['SellersKey' => $_SESSION['sellerData']['SellersKey']])->update($db_data);
        
        $_SESSION['sellerData']['Logo'] = $db_data['Logo'];

        $db_data = array();
        
        $db_data['FirstLogin'] = 0;
        $this->db->table('Users')->where(['UsersKey' => $_SESSION['userData']['UsersKey']])->update($db_data);
               
        $_SESSION['userData']['FirstLogin'] = $db_data['FirstLogin'];

        return true;
    }
    
    public function validatePhoto($seller, $newName, $files, $validated_logo)
    { 
        //check if validation is correct.
        if (!empty($_FILES['logo']['tmp_name'])) 
        {              
            if($validated_logo)
            {                
                $imageName = $seller['Logo'];                  
                         
                // Check if file exists in upload/logos folder if(file_exists(PAD)) {
                $pad = FCPATH . 'uploads/logos/'.$imageName;
                if(file_exists($pad) && !is_dir($pad))
                {
                    // Unlink if exists unlink(FCPATH . 'uploads/logos/NAAMVANLOGOBESTAND')
                    unlink($pad);
                    //echo 2; exit();                   
                }                
                //insert the file and the rest of the info.                
                if($files->move(FCPATH . 'uploads/logos/', $newName) === FALSE)
                {                    
                    return 'The file couldn\'t be uploaded.';                
                }
            }else
            {  
                return 'File validation isn\'t correct check your file again';
            }
        }
        return TRUE;
    }
}