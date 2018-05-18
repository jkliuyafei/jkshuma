<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminSecondGoods extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('secondGoods_model');
    }
    public function index(){
        $data['secondGoods']=$this->secondGoods_model->get_secondGoods();
        $this->load->view('secondGoods/header');
        $this->load->view('templates/menu');
        $this->load->view('secondGoods/index',$data);
        $this->load->view('templates/footer');
    }
    public function handle_goods(){
        $curId=$this->input->post('id');
        $this->secondGoods_model->handle_goods($curId);
    }
    public function update_price(){
        $this->secondGoods_model->update_price();
        redirect('AdminSecondGoods/index');
    }
    
}

?>
