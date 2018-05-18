<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminGoodNum extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('goodNum_model');
    }

    public function index()
    {
        $data['numArr'] = $this->get_num_arr();
        $data['numTenant'] = $this->goodNum_model->get_tenant();
        $data['city'] = $this->goodNum_model->get_city();
        $data['exeDetail'] = $this->goodNum_model->get_exeDetail();
        $this->load->view('goodNum/header');
        $this->load->view('templates/menu');
        $this->load->view('goodNum/index', $data);
        $this->load->view('templates/footer');
    }

    public function get_num_arr()
    {
        $chinaMobile = $this->goodNum_model->get_num('chinaMobile');
        $chinaUnicom = $this->goodNum_model->get_num('chinaUnicom');
        $chinaTelecom = $this->goodNum_model->get_num('chinaTelecom');
        $response = array();
        $response[0]['operatorsName'] = "中国移动";
        $response[0]['numDetail'] = $chinaMobile;
        $response[1]['operatorsName'] = "中国联通";
        $response[1]['numDetail'] = $chinaUnicom;
        $response[2]['operatorsName'] = "中国电信";
        $response[2]['numDetail'] = $chinaTelecom;
        return $response;
    }

    public function add_expense()
    {
        $this->goodNum_model->add_expense();
        redirect('AdminGoodNum/index');
    }

    public function get_main_expense()
    {
        $curOperator = $this->input->post('operator');
        $response = $this->goodNum_model->get_main_expense($curOperator);
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function add_num()
    {
        $this->goodNum_model->add_num();
        redirect('AdminGoodNum/index');
    }
}

?>
