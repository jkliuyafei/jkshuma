<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
class UploadGoods extends CI_Controller {
	public function index() {
		$result = LoginService::check ();
		$response = array ();
		if ($result ['loginState'] === Constants::S_AUTH) {
			// 草泥马比为什么要decode两次，日你奶奶的，草草草
			$upGoodsInfo = file_get_contents ( 'php://input' );
			$upGoodsInfo = json_decode ( $upGoodsInfo, true );
			$upGoodsInfo = $upGoodsInfo ['upGoodsInfo'];
			$upGoodsInfo = json_decode ( $upGoodsInfo, true );
			$this->load->database ();
			$insertData = array (
					'goodsTitle' => $upGoodsInfo ['goodsTitle'],
					'goodsDescribe' => $upGoodsInfo ['goodsDescribe'],
					'goodsStatus' => 1,
					'goodsBrand' => $upGoodsInfo ['goodsBrand'],
					'goodsModel' => $upGoodsInfo ['goodsModel'],
					'goodsVolume' => $upGoodsInfo ['goodsVolume'],
					'goodsColor' => $upGoodsInfo ['goodsColor'],
					'goodsImei' => $upGoodsInfo ['goodsImei'],
					'goodsPrice' => $upGoodsInfo ['goodsPrice'] 
			);
			$queryInsert = $this->db->insert ( 'goods_second', $insertData );
			if ($queryInsert) {
				$queryMax = $this->db->query ( 'SELECT * FROM goods_second ORDER BY id DESC LIMIT 0,1' );
				$row = $queryMax->row ();
				if (isset ( $row )) {
					$curId = $row->id;
					$imageUrl = $upGoodsInfo ['imageAccessUrl'];
					for($i = 0; $i < sizeof ( $imageUrl ); $i ++) {
						$data = array (
								'goodsId' => $curId,
								'accessUrl' => $imageUrl [$i],
								'imageIndex' => $i 
						);
						$this->db->insert('goods_image',$data);
					}
				}
			}
		} else {
			$this->json ( [ 
					'code' => - 1,
					'data' => [ ] 
			] );
		}
		// echo json_encode($response, JSON_FORCE_OBJECT);
	}
}
?>