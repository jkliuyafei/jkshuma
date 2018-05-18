<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Other_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }

    public function get_tenant()
    {
        $this->db->select('*')->from('tenant');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_modelColor()
    {
        $response = array();
        $queryModel = $this->db->query('SELECT DISTINCT model FROM model_color');
        foreach ($queryModel->result_array() as $row) {
            $response[]['model'] = $row['model'];
        }
        for ($j = 0; $j < sizeof($response); $j ++) {
            $curModel = $response[$j]['model'];
            $this->db->select('modelColor')
                ->from('model_color')
                ->where('model', $curModel);
            $query = $this->db->get();
            $response[$j]['modelColorArr'] = $query->result_array();
            $response[$j]['rowspan'] = sizeof($query->result_array());
        }
        return $response;
    }

    public function get_modelVolume()
    {
        $response = array();
        $queryModel = $this->db->query('SELECT DISTINCT model FROM model_volume');
        foreach ($queryModel->result_array() as $row) {
            $response[]['model'] = $row['model'];
        }
        for ($j = 0; $j < sizeof($response); $j ++) {
            $curModel = $response[$j]['model'];
            $this->db->select('modelVolume')
                ->from('model_volume')
                ->where('model', $curModel);
            $query = $this->db->get();
            $response[$j]['modelVolumeArr'] = $query->result_array();
            $response[$j]['rowspan'] = sizeof($query->result_array());
        }
        return $response;
    }

    public function get_shareMessage()
    {
        $this->db->select('*')->from('share_message');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_tenant()
    {
        $shopName = $this->input->post('shopName');
        $leadershipName = $this->input->post('leadershipName');
        $phoneNum1 = $this->input->post('phoneNum1');
        $phoneNum2 = $this->input->post('phoneNum2');
        $tenantType = $this->input->post('tenantType');
        $data = array(
            'shopName' => $shopName,
            'leadershipName' => $leadershipName,
            'phoneNumber1' => $phoneNum1,
            'phoneNumber2' => $phoneNum2,
            'tenantType' => $tenantType
        );
        return $this->db->insert('tenant', $data);
    }

    public function get_brand()
    {
        $query = $this->db->query('SELECT DISTINCT brand FROM model');
        return $query->result_array();
    }

    public function get_model($brand)
    {
        $this->db->select('model')
            ->from('model')
            ->where(array(
            'brand' => $brand,
            'secondGoods' => 1
        ))
            ->order_by('modelOrder', 'DESC');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $response[] = $row['model'];
        }
        return $response;
    }

    public function get_volume()
    {
        $this->db->select('*')->from('volume');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_color()
    {
        $this->db->select('*')->from('color');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_info()
    {
        $phoneModel = $this->input->post('model');
        $phoneColor = $this->input->post('color');
        $phoneVolume = $this->input->post('volume');
        for ($i = 0; $i < sizeof($phoneColor); $i ++) {
            $data = array(
                'model' => $phoneModel,
                'modelColor' => $phoneColor[$i]
            );
            $this->db->insert('model_color', $data);
            unset($data);
        }
        for ($j = 0; $j < sizeof($phoneVolume); $j ++) {
            $data = array(
                'model' => $phoneModel,
                'modelVolume' => $phoneVolume[$j]
            );
            $this->db->insert('model_volume', $data);
            unset($data);
        }
    }
}