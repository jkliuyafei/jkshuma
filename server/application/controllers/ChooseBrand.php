<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
class ChooseBrand extends CI_Controller {
	public function index() {
	    $resultLogin=LoginService::check();
	    if ($resultLogin['loginState'] === Constants::S_AUTH) {
	        $response=array();
	        $brandArr=array();
	        $this->load->database();
	        //查询brand表获取品牌和brandId；
	        $queryBrandId=$this->db->get('brand');
	        foreach ($queryBrandId->result_array() as $row){
	            $brandArr[]=$row;
	        }
	        //查询表中有多少型号，然后遍历brandArr获取对应的brandId用于前端定位，最后拼装response相关属性
	        $queryBrand=$this->db->query('SELECT DISTINCT brand FROM model');
	        $i=0;
	        foreach ($queryBrand->result() as $row){
	            $response[$i]['brand']=$row->brand;
	            $curPhoneBrand=$row->brand;
	            for ($j = 0; $j < sizeof($brandArr); $j++) {
	                if ($curPhoneBrand==$brandArr[$j]['brand']) {
	                    $response[$i]['brandId']=$brandArr[$j]['brandId'];
	                }
	            }
	            $i++;
	        }
	        for ($i = 0; $i < sizeof($response); $i++) {
	            $curBrand=$response[$i]['brand'];
	            $this->db->select('*')->from('model')->where(array('brand'=>$curBrand,'secondGoods'=>1))->order_by('modelOrder','DESC');
	            $queryModel=$this->db->get();
	            foreach ($queryModel->result_array() as $row){
	                $response[$i]['modelGroup'][]=$row;
	            }
	        }
	        $this->db->close();
	        $this->json([
	            'code' => 0,
	            'data' =>$response
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