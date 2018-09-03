<?php

namespace Draguo\Dingtalk\QrConnect;

use Draguo\Dingtalk\Core\BaseClient;

class Socialite extends BaseClient
{

    protected $appId;
    protected $appSecret;
    protected $accessToken;

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    // 单个 app 可用，和企业调用的 access_token 不一样
    public function getAccessToken()
    {
        if (!$this->accessToken) {
            $response = $this->get('/sns/gettoken', ['appid' => $this->appId, 'appsecret' => $this->appSecret]);
            $this->accessToken = $response['access_token'];
        }
        return $this->accessToken;
    }

    /**
     * @param $tmp_auth_code
     * @return array|string
     * 返回例子
     * "errcode": 0,
     * "errmsg": "ok",
     * "openid": "liSii8KCxxxxx",
     * "persistent_code": "dsa-d-asdasdadHIBIinoninINIn-ssdasd",
     * "unionid": "7Huu46kk"
     */
    public function getPersistentCode($tmp_auth_code)
    {
        return $this->postJson('/sns/get_persistent_code?access_token=' . $this->getAccessToken(), compact('tmp_auth_code'));
    }

    /**
     * @param $openid
     * @param $persistent_code
     * @return string
     */
    public function getSnsToken($openid, $persistent_code)
    {
        $response = $this->postJson('/sns/get_sns_token?access_token=' . $this->getAccessToken(),
            compact('openid', 'persistent_code'));
        return $response['sns_token'];
    }

    /**
     * @param $code 前台获取的 code
     * @return array|string
     * @throws \Exception
     */
    public function getUserInfo($code)
    {
        $persistent = $this->getPersistentCode($code);
        return $this->get('/sns/getuserinfo', [
            'sns_token' => $this->getSnsToken($persistent['openid'], $persistent['persistent_code'])
        ]);
    }
}