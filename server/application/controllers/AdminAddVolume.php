<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminAddVolume extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('addVolume_model');
    }

    public function index()
    {
        $data['addVolume'] = $this->addVolume_model->get_addVolume();
        $data['iphoneModel'] = $this->addVolume_model->get_iphoneModel();
        $this->load->view('addVolume/header');
        $this->load->view('templates/menu');
        $this->load->view('addVolume/index', $data);
        $this->load->view('templates/footer');
    }

    public function add_iphoneModel()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('phoneModel', '请选择型号', 'required');
        
        if ($this->form_validation->run() === FALSE) {} else {
            $this->addVolume_model->add_iphoneModel();
            redirect('AdminAddVolume/index');
        }
    }

    public function update_price()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->addVolume_model->update_price();
        
        redirect('AdminAddVolume/index');
    }
}

?>
