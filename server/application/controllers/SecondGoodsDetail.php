<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;
class SecondGoodsDetail extends CI_Controller {
	public function index() {
	    $resultLogin = MyLoginService::check();
	    if ($resultLogin['loginState'] === Constants::S_AUTH) {
	        $goodsImage=array();
	        $requestData = file_get_contents ( 'php://input' );
	        $requestData=json_decode ($requestData,true);
	        $goodsId=(int)$requestData['goodsId'];
	        $this->load->database ();
	        $this->db->select('*')->from('goods_second')->where('id',$goodsId);
	        $queryGoods=$this->db->get();
	        $GoodsDetail=$queryGoods->row_array();
	        $GoodsDetail['goodsImei']="****".substr($GoodsDetail['goodsImei'],-6);
	        $GoodsDetail['goodsImageUrl']=json_decode($GoodsDetail['goodsImageUrl']);
	        $this->json([
	            'code'=>0,
	            'data'=>$GoodsDetail
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