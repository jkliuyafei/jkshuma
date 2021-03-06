<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;
class GoodNum extends CI_Controller {
	public function index() {
	    $resultLogin = MyLoginService::check();
	    if ($resultLogin['loginState'] === Constants::S_AUTH) {
		$response = array ();
		$goodNumber = array ();
		$this->load->database ();
		$this->db->select('*')->from('share_message')->where('page','goodNumber');
		$queryShareMessage=$this->db->get();
		$shareMessage=$queryShareMessage->row_array();
		$response=array(
		    'shareMessage' => $shareMessage
		);	
		$queryNumber = $this->db->get ( 'phone_number' );
		$i = 1;
		$j = 1;
		$k = 1;
		foreach ( $queryNumber->result () as $rowNum ) {
			switch ($rowNum->operators) {
				case "chinaMobile" :
					$goodNumber [0] ['operatorsId'] = 'chinaMobile';
					$goodNumber [0] ['operatorsName'] = '中国移动';
					$goodNumber [0] ['chinaMobileNumber'] [$i - 1] ['numberIndex'] = $i;
					$goodNumber [0] ['chinaMobileNumber'] [$i - 1] ['phoneNumber'] = $rowNum->phoneNumber;
					$goodNumber [0] ['chinaMobileNumber'] [$i - 1] ['qCellCore'] = $rowNum->qCellCore;
					$goodNumber [0] ['chinaMobileNumber'] [$i - 1] ['price'] = $rowNum->price;
					$goodNumber [0] ['chinaMobileNumber'] [$i - 1] ['expensesDetail'] = $rowNum->expensesDetail;
					$i ++;
					break;
				case "chinaUnicom" :
					$goodNumber [1] ['operatorsId'] = 'chinaUnicom';
					$goodNumber [1] ['operatorsName'] = '中国联通';
					$goodNumber [1] ['chinaUnicomNumber'] [$j - 1] ['numberIndex'] = $j;
					$goodNumber [1] ['chinaUnicomNumber'] [$j - 1] ['phoneNumber'] = $rowNum->phoneNumber;
					$goodNumber [1] ['chinaUnicomNumber'] [$j - 1] ['qCellCore'] = $rowNum->qCellCore;
					$goodNumber [1] ['chinaUnicomNumber'] [$j - 1] ['price'] = $rowNum->price;
					$goodNumber [1] ['chinaUnicomNumber'] [$j - 1] ['expensesDetail'] = $rowNum->expensesDetail;
					$j ++;
					break;
				case "chinaTelecom" :
					$goodNumber [2] ['operatorsId'] = 'chinaTelecom';
					$goodNumber [2] ['operatorsName'] = '中国电信';
					$goodNumber [2] ['chinaTelecomNumber'] [$k - 1] ['numberIndex'] = $k;
					$goodNumber [2] ['chinaTelecomNumber'] [$k - 1] ['phoneNumber'] = $rowNum->phoneNumber;
					$goodNumber [2] ['chinaTelecomNumber'] [$k - 1] ['qCellCore'] = $rowNum->qCellCore;
					$goodNumber [2] ['chinaTelecomNumber'] [$k - 1] ['price'] = $rowNum->price;
					$goodNumber [2] ['chinaTelecomNumber'] [$k - 1] ['expensesDetail'] = $rowNum->expensesDetail;
					$k ++;
			}
		}
		$this->db->close ();
		$i = $j = $k = 1;
		$response ['goodNumber'] = $goodNumber;
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