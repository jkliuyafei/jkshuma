<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class GetPageShare extends CI_Controller
{
    
    public function index()
    {
        $response=array();
        $this->load->database();
        $result = MyLoginService::check();
        if ($result['loginState'] === Constants::S_AUTH) {
            $page=$_GET['page'];
            $this->db->select('*')->from('share_message')->where('page',$page);
            $result=$this->db->get();
            $this->json([
                'code' => 0,
                'data' => $result->row_array()
            ]);
        } else {
            $this->json([
                'code' => -1,
                'data' => []
            ]);
        }
    }
}
?>