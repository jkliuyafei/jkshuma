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
	       $secondGoods=$queryGoods->result_array();
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