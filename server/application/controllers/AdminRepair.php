<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminRepair extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('repair_model');
    }
    public function index(){
        $data['repair']=$this->repair_model->get_repair('phone_repair');
        $data['c_repair']=$this->repair_model->get_repair('c_phone_repair');
        $data['allBrand'] = $this->repair_model->get_brand();
        $this->load->view('repair/header');
        $this->load->view('templates/menu');
        $this->load->view('repair/index',$data);
        $this->load->view('templates/footer');
    }
    public function get_model()
    {
        $curPhoneBrand = $this->input->post('phoneBrand');
        $response = $this->repair_model->get_model($curPhoneBrand);
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    public function add_model(){
        $this->repair_model->add_model();
        redirect('AdminRepair/index');
    }
    public function update_retail_price(){
        $this->repair_model->update_price('phone_repair');
        redirect('AdminRepair/index');
    }
    public function update_cost_price(){
        $this->repair_model->update_price('c_phone_repair');
        redirect('AdminRepair/index');
    }
}

?>
