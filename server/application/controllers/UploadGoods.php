<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class UploadGoods extends CI_Controller
{

    public function index()
    {
        $this->load->database();
        $result = LoginService::check();
        $response = array();
        if ($result['loginState'] === Constants::S_AUTH) {
            $data = file_get_contents ( 'php://input' );
            $data = json_decode ( $data, true );
            $imageUrl =$data['imageUrl'];
            $goodsParameter = $data['goodsParameter'];
            $upGoodsInfo = $data['upGoodsInfo'];
            $insertData = array (
                'goodsTitle' => $upGoodsInfo ['goodsTitle'],
                'goodsDescribe' => $upGoodsInfo ['goodsDescribe'],
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
                $queryMax = $this->db->query ( 'SELECT * FROM goods_second ORDER BY id DESC LIMIT 0,1' );
                $row = $queryMax->row ();
                if (isset ( $row )) {
                    $data=array();
                    $curId = $row->id;
                    for($i = 0; $i < sizeof ( $imageUrl ); $i ++) {
                        $data[$i]['goodsId']=$curId;
                        $data[$i]['accessUrl']=$imageUrl[$i]['imageUrl'];
                        $data[$i]['imageIndex']=$imageUrl[$i]['imageIndex'];
                    }
                    $result=$this->db->insert_batch('goods_image', $data);
                    if($result){
                        $this->json([
                            'code' => 0,
                            'data' =>[]
                        ]);}
                        
                }
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