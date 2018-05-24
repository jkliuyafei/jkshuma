<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class GetAllShareMessage extends CI_Controller
{
    
    public function index()
    {
        $result = MyLoginService::check();
        if ($result['loginState'] === Constants::S_AUTH) {
            $openId = $result['userinfo'];
            $this->load->database();
            // 查询该openid是否在user表中
            $this->db->select('*')
            ->from('user')
            ->where('openId', $openId);
            $queryUser = $this->db->get();
            $queryResult = $queryUser->row_array();
            // 结果数组为空说明首次登陆，首次登陆默认role为4，把其openid存入user后，查询权限表role为4的权限
            if (empty($queryResult)) {
                $data = array(
                    'openId' => $openId
                );
                $queryInsert = $this->db->insert('user', $data);
                if ($queryInsert == true) {
                    $this->db->select('*')
                    ->from('wechat_user_auth')
                    ->where('role', '4');
                    $query = $this->db->get();
                    $this->json([
                        'code' => 0,
                        'data' => $query->row_array()
                    ]);
                }
            }else{
                $role=$queryResult['role'];
                $this->db->select('*')
                ->from('wechat_user_auth')
                ->where('role', $role);
                $query = $this->db->get();
                $this->json([
                    'code' => 0,
                    'data' => $query->row_array()
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