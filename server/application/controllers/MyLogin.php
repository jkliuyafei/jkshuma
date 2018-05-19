<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use QCloud_WeApp_SDK\Auth\MyLoginService as MyLoginService;
use QCloud_WeApp_SDK\Constants as Constants;

class MyLogin extends CI_Controller {
    public function index() {
        $result = MyLoginService::login();
        
        if ($result['loginState'] === Constants::S_AUTH) {
            $this->json([
                'code' => 0,
                'data' => $result['respond']
            ]);
        } else {
            $this->json([
                'code' => -1,
                'error' => $result['error']
            ]);
        }
    }
}
