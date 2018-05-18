<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class AuthTab extends CI_Controller
{

    public function index()
    {
        $result = LoginService::check();
        $response = array();
        
        if ($result['loginState'] === Constants::S_AUTH) {
            
            $openId = $result['userinfo']['openId'];
            $nickName = $result['userinfo']['nickName'];
            $avatarUrl = $result['userinfo']['avatarUrl'];
            $gender = $result['userinfo']['gender'];
            $city = $result['userinfo']['city'];
            $province = $result['userinfo']['province'];
            $country = $result['userinfo']['country'];
            $this->load->database();
            $this->db->select('*')
                ->from('user')
                ->where('openId', $openId);
            $queryUser = $this->db->get();
            $queryResult = empty($queryUser->row_array());
            
            if ($queryResult) {
                $data = array(
                    'openId' => $openId,
                    'nickName' => $nickName,
                    'avatarUrl' => $avatarUrl,
                    'gender' => $gender,
                    'city' => $city,
                    'province' => $province,
                    'country' => $country
                );
                
                $queryInsert = $this->db->insert('user', $data);
                if ($queryInsert == true) {
                    $this->db->select('*')
                        ->from('wechat_user_auth')
                        ->where('role', '4');
                    $query = $this->db->get();
                    $response = array(
                        'code' => 0,
                        'message' => 'ok',
                        'state' => $queryInsert,
                        'data' => $query->row_array()
                    );
                }
            } else {
                $row = $queryUser->row_array();
                $role = $row['role'];
                $this->db->select('*')
                    ->from('wechat_user_auth')
                    ->where('role', $role);
                $query = $this->db->get();
                $response = array(
                    'code' => 0,
                    'message' => 'ok',
                    'role'=>$role,
                    'data' => $query->row_array()
                );
            }
        } else {
            $this->json([
                'code' => - 1,
                'data' => []
            ]);
        }
        
        echo json_encode($response, JSON_FORCE_OBJECT);
    }
}
?>