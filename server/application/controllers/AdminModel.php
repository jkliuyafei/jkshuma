<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminModel extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('model_model');
    }
    public function index(){
        $data['model']=$this->model_model->get_model();
        $data['allBrand']=$this->model_model->get_brand();
        
        $this->load->view('model/header');
        $this->load->view('templates/menu');
        $this->load->view('model/index',$data);
        $this->load->view('templates/footer');
    }
    public function add_model(){
    	$this->load->helper('form');
    	$this->load->library('form_validation');
    	$this->form_validation->set_rules('phoneBrand', '请选择品牌', 'required');
    	$this->form_validation->set_rules('model', '请输入型号', 'required');
    	if ($this->form_validation->run() === FALSE)
    	{
    	}
    	else
    	{
    		$this->model_model->add_model();
    		redirect('AdminModel/index');
    	}
    }
    public function handle_model(){
        $curId=$this->input->post('id');
        $this->model_model->handle_model($curId);
    }
   

}

?>
