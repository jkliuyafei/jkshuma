<?php
defined('BASEPATH') or exit('No direct script access allowed');
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class ChooseParameter extends CI_Controller
{

    public function index()
    {
        $resultLogin = LoginService::check();
        if ($resultLogin['loginState'] === Constants::E_AUTH) {
            echo '无操作权限';
            return;
        } else {
            $volumeGroup = array();
            $colorGroup = array();
            $response = array();
            $phoneModel = $_GET['phoneModel'];
            $this->load->database();
            // 获取型号内存数据
            $this->db->select('modelVolume')
                ->from('model_volume')
                ->where('model', $phoneModel);
            $queryVolumeGroup = $this->db->get();
            foreach ($queryVolumeGroup->result_array() as $row) {
                $volumeGroup[] = $row['modelVolume'];
            }
            // 获取型号颜色数据源
            $this->db->select('modelColor')
                ->from('model_color')
                ->where('model', $phoneModel);
            $queryColorGroup = $this->db->get();
            foreach ($queryColorGroup->result_array() as $row) {
                $colorGroup[] = $row['modelColor'];
            }
            $response = array(
                'colorGroup' => $colorGroup,
                'volumeGroup' => $volumeGroup
            );
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
}
?>