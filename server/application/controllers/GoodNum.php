<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class GoodNum extends CI_Controller {
	public function index() {
		$response = array ();
		$goodNumber = array ();
		$this->load->database ();
		$queryShareMessage = $this->db->get_where ( 'share_message', array (
				'page' => 'goodNumber' 
		) );
		$rowShareMessage = $queryShareMessage->row ();
		if (isset ( $rowShareMessage )) {
			$response = array (
					'shareMessage' => $rowShareMessage->message 
			);
		}
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
		echo json_encode ( $response, JSON_FORCE_OBJECT );
	}
}
?>