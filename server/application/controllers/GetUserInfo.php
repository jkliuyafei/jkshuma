<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class GetUserInfo extends CI_Controller
{

    public function index()
    {
        $result = MyLoginService::check();
        if ($result['loginState'] === Constants::S_AUTH) {
            $openId = $result['userinfo'];
            $response=array();
            $response['openId']=$openId;
            $this->load->database();
            // 查询该openid是否在user表中
            $this->db->select('*')
                ->from('user')
                ->where('openId', $openId);
            $queryUser = $this->db->get();
            $queryResult = $queryUser->row_array();
            // 结果数组为空说明首次登陆，首次登陆默认role为user，把其openid存入user表，返回openid和role
            if (empty($queryResult)) {
                $data = array(
                    'openId' => $openId
                );
                $queryInsert = $this->db->insert('user', $data);
                if ($queryInsert == true) {
                    $response['role']="user";
                    $this->json([
                        'code' => 0,
                        'data' => $response
                    ]);
                }
            }else{
                $response['role']=$queryResult['role'];
                 $this->json([
                     'code' => 0,
                     'data' => $response
                 ]);
            }
        } else {
            $this->json([
                'code' => -1,
                'data' => []
            ]);
        }
    }
}
?>