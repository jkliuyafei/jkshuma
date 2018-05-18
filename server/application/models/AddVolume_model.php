<?php
defined('BASEPATH') or exit('No direct script access allowed');
class AddVolume_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_addVolume(){
        $query=$this->db->get('iphone_add_volume');
        return $query->result_array();
    }
    public function get_iphoneModel(){
        $this->db->select('model')->from('model')->where('brand','苹果');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function add_iphoneModel(){
        $data=array(
            'model'=>$this->input->post('phoneModel'),
            'volume32'=>$this->input->post('g32'),
            'volume64'=>$this->input->post('g64'),
            'volume128'=>$this->input->post('g128'),
            'volume256'=>$this->input->post('g256')
        );
        return $this->db->insert('iphone_add_volume',$data);
    }
    public function update_price(){
        $query=$this->db->get('iphone_add_volume');
        foreach ($query->result_array() as $row){
            $id=$row['id'];
            $g32="g32"."$id";
            $g64="g64"."$id";
            $g128="g128"."$id";
            $g256="g256"."$id";

            $data=array(
                'volume32'=>empty($this->input->post("$g32"))?$row['volume32']:$this->input->post("$g32"),
                'volume64'=>empty($this->input->post("$g64"))?$row['volume64']:$this->input->post("$g64"),
                'volume128'=>empty($this->input->post("$g128"))?$row['volume128']:$this->input->post("$g128"),
                'volume256'=>empty($this->input->post("$g256"))?$row['volume256']:$this->input->post("$g256"),
            );
            $this->db->where('id',$id);
             $this->db->update('iphone_add_volume',$data);
             
        }
    }
    
}