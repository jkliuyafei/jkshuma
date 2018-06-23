<?php
defined('BASEPATH') or exit('No direct script access allowed');


use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class UploadGoods extends CI_Controller
{

    public function index()
    {
        $this->load->database();
        $result = MyLoginService::check();
        $openId = $result['userinfo'];
        $response = array();
        if ($result['loginState'] === Constants::S_AUTH) {
            $data = file_get_contents ( 'php://input' );
            $data = json_decode ( $data, true );
            $imageUrl =$data['imageUrl'];
            $goodsParameter = $data['goodsParameter'];
            $upGoodsInfo = $data['upGoodsInfo'];
            $insertData = array (
                'userId'=>$openId,
                'goodsTitle' => $upGoodsInfo ['goodsTitle'],
                'goodsDescribe' => $upGoodsInfo ['goodsDescribe'],
                'goodsImageUrl'=>$imageUrl,
                'goodsStatus' => 1,
                'goodsBrand' => $goodsParameter ['goodsBrand'],
                'goodsModel' => $goodsParameter ['goodsModel'],
                'goodsVolume' => $goodsParameter ['goodsVolume'],
                'goodsColor' => $goodsParameter ['goodsColor'],
                'goodsImei' => $upGoodsInfo ['goodsImei'],
                'goodsPrice' => $upGoodsInfo ['goodsPrice']
            );
            $queryInsert = $this->db->insert ( 'goods_second', $insertData );
            if ($queryInsert) {
                $this->json([
                    'code' => 0,
                    'data' =>[]
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