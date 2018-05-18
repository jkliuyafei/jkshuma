<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GoodNum_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_num($operatorsName)
    {
        $this->db->select('*')
            ->from('phone_number')
            ->where('operators', $operatorsName);
        $queryNum = $this->db->get();
        return $queryNum->result_array();
    }

    public function get_tenant()
    {
        $this->db->select('*')
            ->from('tenant')
            ->where('tenantType', '1');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_expense()
    {
        $tenant = $this->input->post('expen-form-tenant');
        $operators = $this->input->post('expen-form-operator');
        $qCellCore = $this->input->post('expen-form-qCellCore');
        $price = $this->input->post('expen-form-price');
        $costPrice = $this->input->post('expen-form-costprice');
        $type = $this->input->post('expen-form-type');
        $expensesDetail = $this->input->post('expen-form-detail');
        
        $data = array(
            'tenant' => $tenant,
            'operators' => $operators,
            'qCellCore' => $qCellCore,
            'price' => $price,
            'costPrice' => $costPrice,
            'structureType' => $type,
            'expensesDetail' => $expensesDetail
        
        );
        return $this->db->insert('number_main_body', $data);
    }

    public function get_city()
    {
        $query = $this->db->get('city');
        return $query->result_array();
    }

    public function get_main_expense($operator)
    {
        $this->db->select('*')
            ->from('number_main_body')
            ->where('operators', $operator)
            ->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_num()
    {
        $data = array();
        $exString = $this->input->post('add-form-expense');
        $numString = $this->input->post('add-form-nums');
        $mainExpenseArr = json_decode($exString, true);
        $numArr = explode(",", $numString);
        for ($i = 0; $i < sizeof($numArr); $i ++) {
            $data[$i]['operators'] = $mainExpenseArr['operators'];
            $data[$i]['phoneNumber'] = $numArr[$i];
            $data[$i]['qCellCore'] = $mainExpenseArr['qCellCore'];
            $data[$i]['price'] = $mainExpenseArr['price'];
            $data[$i]['costPrice'] = $mainExpenseArr['costPrice'];
            $data[$i]['expensesDetail'] = $mainExpenseArr['expensesDetail'];
            $data[$i]['structureType'] = $mainExpenseArr['structureType'];
            $data[$i]['tenant'] = $mainExpenseArr['tenant'];
        }
        return $this->db->insert_batch('phone_number', $data);
    }

    public function get_exeDetail()
    {
        $this->db->select('*')->from('number_main_body')->order_by('id','DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        $this->db->select('*')->from('tenant')->where('tenantType',1);
        $queryTenant=$this->db->get();
        $resultTenant=$queryTenant->result_array();
        $tenantArr=array();
        foreach ($resultTenant as $row){
            $index=$row['id'];
            $tenantArr[$index]=$row['shopName'];
        }
        $operatorArr = array(
            'chinaMobile' => '中国移动',
            'chinaUnicom' => '中国联通',
            'chinaTelecom' => '中国电信'
        );
        $response = array();
        for ($i = 0; $i < sizeof($result); $i ++) {
            $operators=$result[$i]['operators'];
            $response[$i]['index']=$result[$i]['id'];
            $response[$i]['operatorName']=$operatorArr[$operators];
            $response[$i]['operatorId']=$operators;
            $tenantIndex=$result[$i]['tenant'];
            $detail="<b>归属地：</b>".$result[$i]['qCellCore']."；"."<b>类型：</b>".$result[$i]['structureType']."；"."<b>供应商：</b>".$tenantArr[$tenantIndex]."；"."<b>成本价：</b>".$result[$i]['costPrice']."；"."<b>售价：</b>".$result[$i]['price']."；"."<b>资费详情：</b>".$result[$i]['expensesDetail'];
            $response[$i]['detail']=$detail;
        }
        return $response;
    }
}