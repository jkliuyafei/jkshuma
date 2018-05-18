 
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NewPhone_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }

    public function get_newPhone()
    {
        $response = array();
        $queryBrand = $this->db->query('SELECT DISTINCT phoneBrand FROM new_phone');
        foreach ($queryBrand->result_array() as $row) {
            $curBrand = $row['phoneBrand'];
            $this->db->select('*')
                ->from('new_phone')
                ->where('phoneBrand', $curBrand)
                ->order_by('phoneOrder', 'DESC');
            $query = $this->db->get();
            $response=array_merge($response,$query->result_array());
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
            ->where(array(
            'brand' => $curPhoneBrand,
            'modelStatus' => 1
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
        $query = $this->db->get('volume');
        return $query->result_array();
    }

    public function get_color()
    {
        $query = $this->db->get('color');
        return $query->result_array();
    }

    public function add_phone()
    {
        $phoneBrand = $this->input->post('phoneBrand');
        $phoneModel = $this->input->post('phoneModel');
        $phoneVolume = $this->input->post('phoneVolume');
        $phoneColor = $this->input->post('phoneColor');
        $this->db->select('modelOrder')
            ->from('model')
            ->where('model', $phoneModel);
        $query = $this->db->get();
        $row = $query->row_array();
        $phoneOrder = $row['modelOrder'];
        $queryId = $this->db->query("SELECT * FROM new_phone ORDER BY phoneId DESC LIMIT 0,1");
        $rowId = $queryId->row_array();
        $phoneId = $rowId['phoneId'];
        for ($i = 0; $i < sizeof($phoneColor); $i ++) {
            $data = array(
                'phoneBrand' => $phoneBrand,
                'phoneModel' => $phoneModel,
                'phoneVolume' => $phoneVolume,
                'phoneColor' => $phoneColor[$i],
                'phoneOrder' => $phoneOrder,
                'phoneId' => $phoneId + 1 + $i
            );
             $this->db->insert('new_phone', $data);
            unset($data);
        }
    }

    public function get_cur_brand_group()
    {
        $query = $this->db->query("SELECT DISTINCT phoneBrand FROM new_phone");
        return $query->result_array();
    }

    public function handle_price()
    {
        $phoneBrand = $this->input->post('priceBrand');
        $priceOffset = $this->input->post('priceOffset');
        $this->db->query("UPDATE new_phone SET phonePrice=phonePrice+$priceOffset WHERE phoneBrand='$phoneBrand' AND phonePrice>0");
    }

    public function update_price()
    {
        $query = $this->db->get('new_phone');
        foreach ($query->result_array() as $row) {
            $phoneId = $row['phoneId'];
            $phonePrice = $this->input->post("$phoneId");
            if ($phonePrice != 0) {
                $data = array(
                    'phonePrice' => $phonePrice
                );
                $this->db->where('phoneId', $phoneId);
                $this->db->update('new_phone', $data);
            }
        }
    }
    
}