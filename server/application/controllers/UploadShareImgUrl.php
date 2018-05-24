<?php
defined('BASEPATH') or exit('No direct script access allowed');
use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class UploadShareImgUrl extends CI_Controller
{
    
    public function index()
    {
        $this->load->database ();
        $resultLogin = MyLoginService::check();
        if ($resultLogin['loginState'] === Constants::S_AUTH) {
            $data = file_get_contents ( 'php://input' );
            $data = json_decode ( $data, true );
            $imageUrl=$data['imageUrl'];
            $insertData=array();
            for($i=0;$i<sizeof($imageUrl);$i++){
                $insertData[$i]['imageUrl']=$imageUrl[$i];
            }
            $result=$this->db->insert_batch('share_image', $insertData);
            if($result){
            $this->json([
                'code' => 0,
                'data' =>[]
            ]);}
        }else {
            $this->json([
                'code' => -1,
                'data' => []
            ]);
        }
    }
}
?>