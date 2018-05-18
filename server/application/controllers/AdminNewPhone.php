<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminNewPhone extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->model('newPhone_model');
    }

    public function index()
    {
        $data['allBrand'] = $this->newPhone_model->get_brand();
        $data['phoneVolume'] = $this->newPhone_model->get_volume();
        $data['phoneColor'] = $this->newPhone_model->get_color();
        $data['priceBrand'] = $this->newPhone_model->get_cur_brand_group();
        $data['newPhone'] = $this->getNewPhoneQuotation();
        $this->load->view('newPhone/header');
        $this->load->view('templates/menu');
        $this->load->view('newPhone/index', $data);
        $this->load->view('templates/footer');
    }

    public function add_phone()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->newPhone_model->add_phone();
        redirect('AdminNewPhone/index');
    }

    public function get_model()
    {
        $curPhoneBrand = $this->input->post('phoneBrand');
        $response = $this->newPhone_model->get_model($curPhoneBrand);
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function handle_price()
    {
        $this->newPhone_model->handle_price();
        redirect('AdminNewPhone/index');
    }

    public function update_price()
    {
        $this->newPhone_model->update_price();
        redirect('AdminNewPhone/index');
    }

    public function getNewPhoneQuotation()
    {
        $response = array();
        $newPhone = $this->newPhone_model->get_newPhone();
        $brand = $this->searchRepeatFiled($newPhone, "phoneBrand");
        for ($i = 0; $i < sizeof($brand); $i ++) {
            $response[$i]['brand'] = $brand[$i];
            $modelArr = $this->serachArr("phoneBrand", $brand[$i], $newPhone);
            
            $model = $this->searchRepeatFiled($modelArr, "phoneModel");
            for ($j = 0; $j < sizeof($model); $j ++) {
                $response[$i]['exceptBrand'][$j]['model'] = $model[$j];
                $volumeArr = $this->serachArr("phoneModel", $model[$j], $modelArr);
                
                $volume = $this->searchRepeatFiled($volumeArr, "phoneVolume");
                sort($volume);
                for ($k = 0; $k < sizeof($volume); $k ++) {
                    $response[$i]['exceptBrand'][$j]['exceptModel'][$k]['volume'] = $volume[$k];
                    $otherArr = $this->serachArr("phoneVolume", $volume[$k], $volumeArr);
                    
                    for ($m = 0; $m < sizeof($otherArr); $m ++) {
                        $response[$i]['exceptBrand'][$j]['exceptModel'][$k]['other'][$m]['color'] = $otherArr[$m]['phoneColor'];
                        $response[$i]['exceptBrand'][$j]['exceptModel'][$k]['other'][$m]['price'] = $otherArr[$m]['phonePrice'];
                        $response[$i]['exceptBrand'][$j]['exceptModel'][$k]['other'][$m]['phoneId'] = $otherArr[$m]['phoneId'];
                    }
                }
            }
        }
        return $response;
    }
/*给定字段，得出该字段下去重的项目，返回结果数组。两个参数，第一个
 * 参数为数据库返回的二维数组；第二个参数，要处理的字段名字。比如
 * 给定brand，返回brand下不重复的品牌组成的数组。*/
    public function searchRepeatFiled($dataArr, $filedName)
    {
        $sortMap = array();
        for ($i = 0; $i < sizeof($dataArr); $i ++) {
            $curFiledValue = $dataArr[$i][$filedName];
            if (! in_array($curFiledValue, $sortMap)) {
                array_push($sortMap, $curFiledValue);
            }
        }
        return $sortMap;
    }
/* 给定字段，字段值，得到符合给定条件的所有行，组成二维数组返回；
 * 三个参数，字段名，该字段要筛选出来的值，要处理的二维数组。比如筛选
 * brand='苹果'符合这一条件的所有行。*/
    public function serachArr($filedName, $filedValue, $dataArr)
    {
        $response = array();
        for ($i = 0; $i < sizeof($dataArr); $i ++) {
            $curFiledValue = $dataArr[$i][$filedName];
            if ($curFiledValue == $filedValue) {
                $response[] = $dataArr[$i];
            }
        }
        return $response;
    }
}

?>
