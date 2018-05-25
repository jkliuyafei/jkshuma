<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class GetShareMessage extends CI_Controller
{
    
    public function index()
    {
        $response=array();
        $this->load->database();
        $result = MyLoginService::check();
        if ($result['loginState'] === Constants::S_AUTH) {
          $resultMessage=$this->db->get('share_message');
          $messageArr=$resultMessage->result_array();
          $resultImage=$this->db->get('share_image');
          $imageArr=$resultImage->result_array();
          $response['messageArr']=$messageArr;
          $response['imageArr']=$imageArr;
          $this->json([
              'code' => 0,
              'data' => $response
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