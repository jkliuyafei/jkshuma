<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Repair_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_repair($table_name)
    {
        $response=array();
        $queryBrand=$this->db->query("SELECT DISTINCT phoneBrand FROM $table_name");
        foreach ($queryBrand->result() as $row){
            $curBrand=$row->phoneBrand;
            $this->db->select('*')->from($table_name)->where('phoneBrand',$curBrand)->order_by('modelOrder','DESC');
            $query=$this->db->get();
            foreach ($query->result_array() as $row){
                $response[]=$row;
            }  
        }
        return $response;
    }

    public function get_brand()
    {
        $query = $this->db->get('brand');
        return $query->result_array();
    }

    public function get_model($curPhoneBrand)
    {
        $this->db->select('model')
            ->from('model')
            ->where('brand', $curPhoneBrand)
            ->order_by('modelOrder', 'DESC');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $response[] = $row['model'];
        }
        return $response;
    }

    public function add_model()
    {
        $curBrand = $this->input->post('phoneBrand');
        $curModel = $this->input->post('phoneModel');
        $this->db->select('modelOrder')->from('model')->where(array('brand'=>$curBrand,'model'=>$curModel));
        $query=$this->db->get();
        $modelOrderArray=$query->row_array();
        $curModelOrder=$modelOrderArray['modelOrder'];
        $data = array(
            'phoneBrand' => $curBrand,
            'phoneModel' => $curModel,
            'modelOrder'=>$curModelOrder
        );
        $this->db->insert('phone_repair',$data);
        $this->db->insert('c_phone_repair',$data);
    }
    public function update_price($table_name){
        $query=$this->db->get($table_name);
        foreach ($query->result_array() as $row){
            $id=$row['id'];
            $outsideScreenOriginal="outsideOriginal"."$id";
            $outsideScreenAssemble="outsideAssemble"."$id";
            $insideScreenOriginal="insideOriginal"."$id";
            $insideScreenAssemble="insideAssemble"."$id";
            $battery="battery"."$id";
            $phoneShell="phoneShell"."$id";
            $frontCamera="frontCam"."$id";
            $backCamera="backCam"."$id";
            $phoneWinding="phoneWinding"."$id";
            $speaker="speaker"."$id";
            $tailePlug="tailePlug"."$id";
            $phoneUnclock="phoneUnclock"."$id";
            
            $data=array(
                'outsideScreenOriginal'=>empty($this->input->post("$outsideScreenOriginal"))?$row['outsideScreenOriginal']:$this->input->post("$outsideScreenOriginal"),
                'outsideScreenAssemble'=>empty($this->input->post("$outsideScreenAssemble"))?$row['outsideScreenAssemble']:$this->input->post("$outsideScreenAssemble"),
                'insideScreenOriginal'=>empty($this->input->post("$insideScreenOriginal"))?$row['insideScreenOriginal']:$this->input->post("$insideScreenOriginal"),
                'insideScreenAssemble'=>empty($this->input->post("$insideScreenAssemble"))?$row['insideScreenAssemble']:$this->input->post("$insideScreenAssemble"),
                'battery'=>empty($this->input->post("$battery"))?$row['battery']:$this->input->post("$battery"),
                'phoneShell'=>empty($this->input->post("$phoneShell"))?$row['phoneShell']:$this->input->post("$phoneShell"),
                'frontCamera'=>empty($this->input->post("$frontCamera"))?$row['frontCamera']:$this->input->post("$frontCamera"),
                'backCamera'=>empty($this->input->post("$backCamera"))?$row['backCamera']:$this->input->post("$backCamera"),
                'phoneWinding'=>empty($this->input->post("$phoneWinding"))?$row['phoneWinding']:$this->input->post("$phoneWinding"),
                'speaker'=>empty($this->input->post("$speaker"))?$row['speaker']:$this->input->post("$speaker"),
                'tailePlug'=>empty($this->input->post("$tailePlug"))?$row['tailePlug']:$this->input->post("$tailePlug"),
                'phoneUnclock'=>empty($this->input->post("$phoneUnclock"))?$row['phoneUnclock']:$this->input->post("$phoneUnclock")
            );
            $this->db->where('id',$id);
            $this->db->update($table_name,$data);
            
        }
        
    }
}