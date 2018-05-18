<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminOther extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('other_model');
    }
    public function index(){
        $data['volume']=$this->other_model->get_volume();
        $data['color']=$this->other_model->get_color();
        $data['brand']=$this->other_model->get_brand();
        $data['tenant']=$this->other_model->get_tenant();
        $data['modelColor']=$this->other_model->get_modelColor();
        $data['modelVolume']=$this->other_model->get_modelVolume();
        $data['shareMessage']=$this->other_model->get_shareMessage();
        $this->load->view('other/header');
        $this->load->view('templates/menu');
        $this->load->view('other/index',$data);
        $this->load->view('templates/footer');
    }
    public function add_tenant(){
        $this->other_model->add_tenant();
        redirect('AdminOther/index');
    }
    public function get_model(){
        $curBrand=$this->input->post("phoneBrand");
        $response=$this->other_model->get_model($curBrand);
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    public function add_info(){
        $this->other_model->add_info();
        redirect('AdminOther/index');
    }
    
   

    
}

?>
