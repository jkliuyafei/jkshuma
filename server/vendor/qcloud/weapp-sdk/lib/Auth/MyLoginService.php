<?php
namespace QCloud_WeApp_SDK\Auth;

use \Exception as Exception;

use \QCloud_WeApp_SDK\Helper\Util as Util;
use \QCloud_WeApp_SDK\Constants as Constants;

class MyLoginService {
    public static function login() {
        try {
            $code = self::getHttpHeader(Constants::WX_HEADER_CODE);
            return MyAuthAPI::login($code);
        } catch (Exception $e) {
            return [
                'loginState' => Constants::E_AUTH,
                'error' => $e->getMessage()
            ];
        }
    }


    private static function getHttpHeader($headerKey) {
        $headerValue = Util::getHttpHeader($headerKey);

        if (!$headerValue) {
            throw new Exception("请求头未包含 {$headerKey}，请配合客户端 SDK 登录后再进行请求");
        }

        return $headerValue;
    }
}
