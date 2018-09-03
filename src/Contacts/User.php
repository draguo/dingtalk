<?php

namespace Draguo\Dingtalk\Contacts;

use Draguo\Dingtalk\Core\BaseClient;

class User extends BaseClient
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
            $response = $this->get('/gettoken', ['appid' => $this->appId, 'appsecret' => $this->appSecret]);
            $this->accessToken = $response['access_token'];
        }
        return $this->accessToken;
    }

    public function getUserIdByUnionId($unionId)
    {
        return $this->get('/user/getUseridByUnionid', [
            'access_token' => $this->getAccessToken(),
            'unionid' => $unionId
        ]);
    }

    public function getUserInfo($userId)
    {
        return $this->get('/user/get', [
            'access_token' => $this->getAccessToken(),
            'userid' => $userId
        ]);
    }
}