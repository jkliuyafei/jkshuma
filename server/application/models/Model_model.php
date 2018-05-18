<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }

    public function get_model()
    {
        $response=array();
        $queryBrand = $this->db->query('SELECT DISTINCT brand FROM model');
        foreach ($queryBrand->result_array() as $row) {
            $curBrand = $row['brand'];
            $this->db->select('*')
                ->from('model')
                ->where('brand', $curBrand)
                ->order_by('modelOrder', 'DESC');
            $query=$this->db->get();
            foreach ($query->result_array() as $row){
                $response[]=$row;
            }
        }
        return $response;
    }
    public function get_brand(){
    	$query=$this->db->get('brand');
    	return $query->result_array();
    }
    public function add_model() {
    	$newOrOld=$this->input->post('newOrOld');
    	$curBrand=$this->input->post('phoneBrand');
    	if($newOrOld==0){
    		$queryOrder=$this->db->query("SELECT * FROM model WHERE brand='$curBrand' ORDER BY modelOrder ASC LIMIT 0,1");
    		if ($queryOrder->num_rows() > 0){
    			$curRow=$queryOrder->row_array();
    			$curOrder=$curRow['modelOrder'];
    			$data=array(
    					'brand'=>$curBrand,
    					'model'=>$this->input->post('model'),
    					'modelOrder'=>$curOrder-1,
    					'modelStatus'=>0
    			);
    			return $this->db->insert('model',$data);
    		}else{
    			$this->db->select('*')->from('brand')->where('brand',$curBrand);
    			$query=$this->db->get();
    			$row=$query->row_array();
    			$data=array(
    					'brand'=>$curBrand,
    					'model'=>$this->input->post('model'),
    					'modelOrder'=>$row['brandIndex']+150,
    					'modelStatus'=>0
    			);
    			return $this->db->insert('model',$data);
    		}
    	}else{
    		$queryOrder=$this->db->query("SELECT * FROM model WHERE brand='$curBrand' ORDER BY modelOrder DESC LIMIT 0,1");
    		if ($queryOrder->num_rows() > 0){
    			$curRow=$queryOrder->row_array();
    			$curOrder=$curRow['modelOrder'];
    			$data=array(
    					'brand'=>$curBrand,
    					'model'=>$this->input->post('model'),
    					'modelOrder'=>$curOrder+1,
    					'modelStatus'=>1
    			);
    			return $this->db->insert('model',$data);
    		}else{
    			$this->db->select('*')->from('brand')->where('brand',$curBrand);
    			$query=$this->db->get();
    			$row=$query->row_array();
    			$data=array(
    					'brand'=>$curBrand,
    					'model'=>$this->input->post('model'),
    					'modelOrder'=>$row['brandIndex']+150,
    					'modelStatus'=>1
    			);
    			return $this->db->insert('model',$data);
    		}
    	}
    }
    public function handle_model($id){
        $this->db->select('*')->from('model')->where('id',$id);
        $query=$this->db->get();
        $row=$query->row_array();
        
        if ($row['modelStatus']==0) {
            $this->db->query("UPDATE model SET modelStatus=1 WHERE id=$id");
        }elseif ($row['modelStatus']==1){
            $this->db->query("UPDATE model SET modelStatus=0 WHERE id=$id");
            $this->db->delete('new_phone',array('phoneBrand'=>$row['brand'],'phoneModel'=>$row['model']));
           
        }
    }
   
    
}