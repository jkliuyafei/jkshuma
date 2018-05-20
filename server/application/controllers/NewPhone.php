<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;
class NewPhone extends CI_Controller {
	public function index() {
	    $resultLogin = MyLoginService::check();
	    if ($resultLogin['loginState'] === Constants::S_AUTH) {
		$response = array ();
		$brandArr = array ();
		$phoneQuotation = array ();
		$this->load->database ();
		// 查询本页面的分享信息
		$queryShareMessage = $this->db->get_where ( 'share_message', array (
				'page' => 'newPhoneQuotation' 
		) );
		$rowShareMessage = $queryShareMessage->row ();
		if (isset ( $rowShareMessage )) {
			$response ['shareMessage'] = $rowShareMessage->message;
		}
		// 查询brand表获取brand和brandId存入数组
		$queryBrand = $this->db->get ( 'brand' );
		foreach ( $queryBrand->result_array () as $row ) {
			$brandArr [] = $row;
		}
		// 去重查询new_phone表获取新机报价表有多少品牌,然后根据brandArr数组获取相应的brand和brandId存入response数组
		$i = 0;
		$queryBrand = $this->db->query ( 'SELECT DISTINCT phoneBrand FROM new_phone' );
		foreach ( $queryBrand->result () as $row ) {
			$phoneQuotation [$i] ['brand'] = $row->phoneBrand;
			$curBrand = $row->phoneBrand;
			for($j = 0; $j < sizeof ( $brandArr ); $j ++) {
				if ($curBrand == $brandArr [$j] ['brand']) {
					$phoneQuotation [$i] ['brandId'] = $brandArr [$j] ['brandId'];
				}
			}
			$i ++;
		}
		// 根据各个品牌查询数据库得到品牌下的颜色，价格，容量等数据，然后拼装到response数组
		for($i = 0; $i < sizeof ( $phoneQuotation ); $i ++) {
			$curBrand = $phoneQuotation [$i] ['brand'];
			$this->db->select ( '*' )->from ( 'new_phone' )->where ( 'phoneBrand', $curBrand )->order_by ( 'phoneOrder', 'DESC' );
			$queryByBrand = $this->db->get ();
			$resultByBrand = $queryByBrand->result_array ();
			// 遍历数组，获取品牌下属的型号
			$j = 0;
			$modelArr = array ();
			foreach ( $resultByBrand as $row ) {
				if (! in_array ( $row ['phoneModel'], $modelArr )) {
					$modelArr [$j] = $row ['phoneModel'];
					$phoneQuotation [$i] ['exceptBrand'] [$j] ['model'] = $row ['phoneModel'];
					$j ++;
				}
			}
			// 根据型号数组查询数据库获取该型号下的容量
			for($k = 0; $k < sizeof ( $modelArr ); $k ++) {
				$m = 0;
				$queryByModel = $this->db->query ( "SELECT DISTINCT phoneVolume FROM new_phone WHERE phoneModel='{$modelArr[$k]}'" );
				foreach ( $queryByModel->result_array () as $row ) {
					$phoneQuotation [$i] ['exceptBrand'] [$k] ['exceptModel'] [$m] ['volume'] = $row ['phoneVolume'];
					
					$this->db->select ( '*' )->from ( 'new_phone' )->where ( array (
							'phoneModel' => $modelArr [$k],
							'phoneVolume' => $row ['phoneVolume'] 
					) );
					$queryByVolume=$this->db->get();
					$n=0;
					foreach ($queryByVolume->result_array() as $row){	
						$phoneQuotation[$i]['exceptBrand'][$k]['exceptModel'][$m]['other'][$n]['color']=$row['phoneColor'];
						$phoneQuotation[$i]['exceptBrand'][$k]['exceptModel'][$m]['other'][$n]['price']=$row['phonePrice'];
						$phoneQuotation[$i]['exceptBrand'][$k]['exceptModel'][$m]['other'][$n]['phoneId']=$row['phoneId'];
						$n++;
					}
					$m ++;
				}
			}
		}
		$response ['newPhoneQuotation'] = $phoneQuotation;
		//echo json_encode ( $response, JSON_UNESCAPED_UNICODE );
		$this->json([
		    'code' => 0,
		    'data' => $response
		]);
	}
	}
}
?>