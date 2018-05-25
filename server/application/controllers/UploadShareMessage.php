<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class UploadShareMessage extends CI_Controller
{

    public function index()
    {
        $response = array();
        $this->load->database();
        $result = MyLoginService::check();
        if ($result['loginState'] === Constants::S_AUTH) {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            $id = $data['id'];
            $insertData['message'] = $data['message'];
            $insertData['imageUrl'] = $data['imageUrl'];
            $this->db->where('id', $id);
            $resultInsert = $this->db->update('share_message', $data);
            if ($resultInsert) {
                $this->json([
                    'code' => 0,
                    'data' => $data
                
                ]);
            }else {
                $this->json([
                    'code' => - 1,
                    'data' => []
                ]);
            }
        } else {
            $this->json([
                'code' => - 1,
                'data' => []
            ]);
        }
    }
}
?>