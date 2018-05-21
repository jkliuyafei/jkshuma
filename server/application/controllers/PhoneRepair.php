<?php
defined('BASEPATH') or exit('No direct script access allowed');
use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class PhoneRepair extends CI_Controller
{

    public function index()
    {
        $resultLogin = MyLoginService::check();
        if ($resultLogin['loginState'] === Constants::S_AUTH) {
            
            $response = array();
            $brandArr = array();
            $phoneRepairTable = array();
            $this->load->database();
            // 查询本页面的分享信息；
            $queryShareMessage = $this->db->get_where('share_message', array(
                'page' => 'phoneRepair'
            ));
            $rowShareMessage = $queryShareMessage->row();
            if (isset($rowShareMessage)) {
                $response['shareMessage'] = $rowShareMessage->message;
            }
            // 查询brand表获取品牌和brandId；
            $queryBrandId = $this->db->get('brand');
            foreach ($queryBrandId->result_array() as $row) {
                $brandArr[] = $row;
            }
            // 去重查询phone_repair表获取总共多少个品牌,然后以当前所有的品牌遍历brandArr数组，找到brandId，拼装response相关字段
            $queryBrand = $this->db->query('SELECT DISTINCT phoneBrand FROM phone_repair');
            $i = 0;
            foreach ($queryBrand->result() as $row) {
                $phoneRepairTable[$i]['phoneBrand'] = $row->phoneBrand;
                $curPhoneBrand = $row->phoneBrand;
                for ($j = 0; $j < sizeof($brandArr); $j ++) {
                    if ($curPhoneBrand == $brandArr[$j]['brand']) {
                        $phoneRepairTable[$i]['brandId'] = $brandArr[$j]['brandId'];
                    }
                }
                $i ++;
            }
            // 遍历拼装的response，获取品牌，然后根据品牌查询phone_repair表获取某品牌下的维修报价，然后拼装response
            for ($j = 0; $j < sizeof($phoneRepairTable); $j ++) {
                $curBrand = $phoneRepairTable[$j]['phoneBrand'];
                $this->db->select('*')
                    ->from('phone_repair')
                    ->where('phoneBrand', $curBrand)
                    ->order_by('modelOrder', 'DESC');
                $queryItem = $this->db->get();
                $k = 0;
                foreach ($queryItem->result_array() as $row) {
                    $phoneRepairTable[$j]['modelDetail'][$k]['phoneModel'] = $row['phoneModel'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['outsideScreenOriginal'] = $row['outsideScreenOriginal'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['outsideScreenAssemble'] = $row['outsideScreenAssemble'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['insideScreenOriginal'] = $row['insideScreenOriginal'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['insideScreenAssemble'] = $row['insideScreenAssemble'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['battery'] = $row['battery'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['phoneShell'] = $row['phoneShell'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['phoneModelOne'] = $row['phoneModel'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['frontCamera'] = $row['frontCamera'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['backCamera'] = $row['backCamera'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['phoneWinding'] = $row['phoneWinding'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['speaker'] = $row['speaker'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['tailePlug'] = $row['tailePlug'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['phoneUnclock'] = $row['phoneUnclock'];
                    $phoneRepairTable[$j]['modelDetail'][$k]['phoneModelTwo'] = $row['phoneModel'];
                    $k ++;
                }
            }
            $this->db->close();
            $response['phoneRepairTable'] = $phoneRepairTable;
            //echo json_encode($response, JSON_FORCE_OBJECT);
            $this->json([
                'code' => 0,
                'data' => $response
            ]);
        }else {
            $this->json([
                'code' => -1,
                'data' => []
            ]);
        }
    }
}
?>