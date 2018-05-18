<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Brand_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_brand(){
        $query=$this->db->get('brand');
        return $query->result_array();
    }
    public function add_brand(){
       
        $data=array(
            'brand'=>$this->input->post('brand'),
            'brandId'=>$this->input->post('brandId')
        );
        return $this->db->insert('brand',$data);
    }
}