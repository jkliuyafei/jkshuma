<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;
class SecondGoods extends CI_Controller {
	public function index() {
	    $resultLogin = MyLoginService::check();
	    if ($resultLogin['loginState'] === Constants::S_AUTH) {
	        $response=array();
	        $secondGoods=array();
	        $this->load->database ();
	        //获取页面分享信息
	        $this->db->select('*')->from('share_message')->where('page','secondGoodsHome');
	        $queryShareMessage=$this->db->get();
	        $shareMessage=$queryShareMessage->row_array();
	        $response=array(
	            'shareMessage' => $shareMessage
	        );

	        //获取二手商品主体信息，然后根据id查询商品图片表，获取商品图片
	        $this->db->select('*')->from('goods_second')->where('goodsStatus',1)->order_by('uploadTime','DESC');
	        $queryGoods=$this->db->get();
	        $i=0;
	        foreach ($queryGoods->result_array() as $row){
	            $goodsImage=array();
	            $goodsId=$row['id'];
	            $goodsImei=$row["goodsImei"];
	            $goodsImei="****".substr($goodsImei,-6);
	            $uploadTime=$row['uploadTime'];
	            $month=substr($uploadTime,5,2);
	            $day=substr($uploadTime, 8,2);
	            $hour=substr($uploadTime, 11,2);
	            $minute=substr($uploadTime, 14,2);
	            $secondGoods[$i]['id']=$row['id'];
	            $secondGoods[$i]['goodsTitle']=$row['goodsTitle'];
	            $secondGoods[$i]['goodsDescribe']=$row['goodsDescribe'];
	            $secondGoods[$i]['goodsImei']=$goodsImei;
	            $secondGoods[$i]['uploadTime']=$month.'月'.$day.'日'.' '.$hour.':'.$minute;
	            $secondGoods[$i]['goodsPrice']=$row['goodsPrice'];
	            $secondGoods[$i]['goodsBrand']=$row['goodsBrand'];
	            $secondGoods[$i]['goodsModel']=$row['goodsModel'];
	            $secondGoods[$i]['goodsVolume']=$row['goodsVolume'];
	            $secondGoods[$i]['goodsColor']=$row['goodsColor'];
	            //根据商品id查询goods_image表获取单个商品所属的图片
	            $this->db->select('*')->from('goods_image')->where('goodsId',$goodsId)->order_by('imageIndex','ASC');
	            $queryImage=$this->db->get();
	            foreach ($queryImage->result_array() as $row){
	                $goodsImage[]=$row['accessUrl'];
	            }
	            $secondGoods[$i]['goodsImage']=$goodsImage;
	            $i++;
	            unset($goodsImage);
	        }
	        $this->db->close();
	        $response['secondGoods']=$secondGoods;
	        //echo json_encode ( $response, JSON_UNESCAPED_UNICODE);
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