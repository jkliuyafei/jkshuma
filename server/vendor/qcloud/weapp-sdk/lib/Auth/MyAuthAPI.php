<?php
namespace QCloud_WeApp_SDK\Auth;

use \Exception as Exception;

use \QCloud_WeApp_SDK\Conf as Conf;
use \QCloud_WeApp_SDK\Model\User as User;
use \QCloud_WeApp_SDK\Constants as Constants;
use \QCloud_WeApp_SDK\Helper\Logger as Logger;
use \QCloud_WeApp_SDK\Helper\Request as Request;

class MyAuthAPI {
    /**
     * 用户登录接口
     * @param {string} $code        wx.login 颁发的 code
     * @param {string} $encryptData 加密过的用户信息
     * @param {string} $iv          解密用户信息的向量
     * @return {array} { loginState, userinfo }
     */
    public static function login($code) {
        // 1. 获取 session key
        //$sessionKey = self::getSessionKey($code);
        $loginResult = self::getSessionKey($code);
        $sessionKey=$loginResult['session_key'];

        // 2. 生成 3rd key (skey)
        $skey = sha1($sessionKey . mt_rand());
        $openid=$loginResult['openid'];
        
        $userinfo=(object)array('openId'=>$openid);
        //$userinfo=json_encode($userinfo);

        // 4. 储存到数据库中
        User::storeUserInfo($userinfo, $skey, $sessionKey);

        return [
            'loginState' => Constants::S_AUTH,
            'respond' => compact('openid', 'skey')
        ];
    }
    
    public static function checkLogin($skey) {
        $userinfo = User::findUserBySKey($skey);
        if ($userinfo === NULL) {
            return [
                'loginState' => Constants::E_AUTH,
                'userinfo' => []
            ];
        }
        
        $wxLoginExpires = Conf::getWxLoginExpires();
        $timeDifference = time() - strtotime($userinfo->last_visit_time);
        
        if ($timeDifference > $wxLoginExpires) {
            return [
                'loginState' => Constants::E_AUTH,
                'userinfo' => []
            ];
        } else {
            return [
                'loginState' => Constants::S_AUTH,
                'userinfo' => $userinfo->open_id
            ];
        }
    }

   

    /**
     * 通过 code 换取 session key
     * @param {string} $code
     */
    public static function getSessionKey ($code) {
        $useQcProxy = Conf::getUseQcloudLogin();

        /**
         * 是否使用腾讯云代理登录
         * $useQcProxy 为 true，sdk 将会使用腾讯云的 QcloudSecretId 和 QcloudSecretKey 获取 session key
         * 反之将会使用小程序的 AppID 和 AppSecret 获取 session key
         */
        if ($useQcProxy) {
          $loginResult=array();
            $secretId = Conf::getQcloudSecretId();
            $secretKey = Conf::getQcloudSecretKey();
            list($session_key, $openid) = array_values(self::useQcloudProxyGetSessionKey($secretId, $secretKey, $code));
            $loginResult=array('session_key'=>$session_key,'openid'=>$openid);
            return $loginResult;
        } else {
            $appId = Conf::getAppId();
            $appSecret = Conf::getAppSecret();
            list($session_key, $openid) = array_values(self::getSessionKeyDirectly($appId, $appSecret, $code));
            $loginResult=array('session_key'=>$session_key,'openid'=>$openid);
            return $loginResult;
        }
    }

    /**
     * 直接请求微信获取 session key
     * @param {string} $secretId  腾讯云的 secretId
     * @param {string} $secretKey 腾讯云的 secretKey
     * @param {string} $code
     * @return {array} { $session_key, $openid }
     */
    private static function getSessionKeyDirectly ($appId, $appSecret, $code) {
        $requestParams = [
            'appid' => $appId,
            'secret' => $appSecret,
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        ];

        list($status, $body) = array_values(Request::get([
            'url' => 'https://api.weixin.qq.com/sns/jscode2session?' . http_build_query($requestParams),
            'timeout' => Conf::getNetworkTimeout()
        ]));

        if ($status !== 200 || !$body || isset($body['errcode'])) {
            throw new Exception(Constants::E_PROXY_LOGIN_FAILED . ': ' . json_encode($body));
        }

        return $body;
    }

    /**
     * 通过腾讯云代理获取 session key
     * 这里是一个完整的腾讯云云 API 实现
     * @param {string} $secretId  腾讯云的 secretId
     * @param {string} $secretKey 腾讯云的 secretKey
     * @param {string} $code
     * @return {array} { $session_key, $openid }
     */
    private static function useQcloudProxyGetSessionKey ($secretId, $secretKey, $code) {
        if (!isset($secretId, $secretKey, $code)) {
            throw new Exception(Constants::E_PROXY_LOGIN_LOST_PRAMA);
        }

        $requestUrl = 'wss.api.qcloud.com/v2/index.php';
        $requestMethod = 'GET';
        $requestData = [
            'Action' => 'GetSessionKey',
            'js.code' => $code,
            'Timestamp' => time(),
            'Nonce' => mt_rand(),
            'SecretId' => $secretId,
            'SignatureMethod' => 'HmacSHA256'
        ];

        ksort($requestData);
        $requestString = http_build_query($requestData);
        $signatureRawString = $requestMethod . $requestUrl . '?' . $requestString;

        $requestData['Signature'] = base64_encode(hash_hmac('sha256', $signatureRawString, $secretKey, true));

        list($status, $body) = array_values(Request::get([
            'url' => 'https://' . $requestUrl . '?' . http_build_query($requestData),
            'timeout' => Conf::getNetworkTimeout()
        ]));

        if ($status !== 200 || !$body || $body['code'] !== 0) {
            throw new Exception(Constants::E_PROXY_LOGIN_REQUEST_FAILED);
        }

        if (isset($body['data']['errcode'])) {
            throw new Exception(Constants::E_PROXY_LOGIN_FAILED . ': ' . json_encode($body['data']));
        }

        return $body['data'];
    }
}
