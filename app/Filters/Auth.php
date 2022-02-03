<?php namespace App\Filters;
 
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
 
class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check user login
        if(!session()->get('isLoggedIn')){
            return redirect()->to('/'); 
        } else {
            if(session()->get('userData') == false) {
                return redirect()->to('/');
            } else {
                $userData = session()->get('userData');
                if(!isset($userData['UsersKey'])) {
                    return redirect()->to('/');
                } else {
                    if(isset($userData['Position']) && $userData['Position'] == "RREW Portal User") {
                        // - Do nothing
                    } else {
                        $db = \Config\Database::connect();
                        $builderUsers = $db->table('Users');
                        $query = $builderUsers->where('UsersKey', $userData['UsersKey'])->get();
                        if($query->getNumRows() == 0) {
                            return redirect()->to('/');
                        }
                    }
                }
            }
        }
        //
    }
 
    //--------------------------------------------------------------------
 
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        echo 'when';
    }
}