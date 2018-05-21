<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
use \QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;
class AddVolume extends CI_Controller {
	public function index() {
	    $resultLogin = MyLoginService::check();
	    if ($resultLogin['loginState'] === Constants::S_AUTH) {
	    
		$response=array();
		$iphoneAddVolume=array();
		$this->load->database ();
		$queryShareMessage = $this->db->get_where ( 'share_message', array (
				'page' => 'iphoneAddVolume' 
		) );
		$rowShareMessage=$queryShareMessage->row();
		if(isset($rowShareMessage)){
			$response=array(
					'shareMessage' => $rowShareMessage->message,
			);
		}
		$queryAddVolume=$this->db->get('iphone_add_volume');
		$j=0;
		foreach ($queryAddVolume->result() as $rowAddVolume){
			$iphoneAddVolume[$j]['model']=$rowAddVolume->model;
			$iphoneAddVolume[$j]['volume32']=$rowAddVolume->volume32;
			$iphoneAddVolume[$j]['volume64']=$rowAddVolume->volume64;
			$iphoneAddVolume[$j]['volume128']=$rowAddVolume->volume128;
			$iphoneAddVolume[$j]['volume256']=$rowAddVolume->volume256;
			$j++;
		}
		$this->db->close();
		$j=0;
		$response['iphoneAddVolume']=$iphoneAddVolume;
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