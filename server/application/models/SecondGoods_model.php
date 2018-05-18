<?php
defined('BASEPATH') or exit('No direct script access allowed');
class SecondGoods_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_secondGoods(){
        $this->db->select('*')->from('goods_second')->order_by('id','DESC');
        $query=$this->db->get();
        return $query->result_array();
    }
    public function handle_goods($id){
        $this->db->query("UPDATE goods_second SET goodsStatus=0 WHERE id=$id");
    }
    public function update_price(){
        $query=$this->db->get('goods_second');
        foreach ($query->result_array() as $row){
            $id=$row['id'];
            $goodsPrice=$this->input->post("$id");
            if($goodsPrice!=0){
                $data=array(
                    'goodsPrice'=>$goodsPrice,
                );
                $this->db->where('id',$id);
                $this->db->update('goods_second',$data);
            }
        }
    }
   
}