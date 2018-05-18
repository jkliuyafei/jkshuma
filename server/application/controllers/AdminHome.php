<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminHome extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('brand_model');
    }
    public function index(){
        $data['brand']=$this->brand_model->get_brand();
        $this->load->view('brand/header');
        $this->load->view('templates/menu');
        $this->load->view('brand/index',$data);
        $this->load->view('templates/footer');
    }
    public function add_brand(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('brand', '请输入品牌', 'required');
        $this->form_validation->set_rules('brandId', '请输入品牌id', 'required');
        if ($this->form_validation->run() === FALSE)
        {      
        }
        else
        {
            $this->brand_model->add_brand();
            redirect('AdminHome/index');
        }
    }
}

?>
