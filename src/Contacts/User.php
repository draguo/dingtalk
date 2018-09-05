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

    public function getUserIdByUnionId($unionId)
    {
        return $this->get('/user/getUseridByUnionid', [
            'access_token' => $this->getAccessToken($this->appId, $this->appSecret),
            'unionid' => $unionId
        ])['userid'];
    }

    public function findByUnionId($unionId)
    {
        return $this->getUserInfo($this->getUserIdByUnionId($unionId));
    }

    public function getUserInfo($userId)
    {
        return $this->get('/user/get', [
            'access_token' => $this->getAccessToken($this->appId, $this->appSecret),
            'userid' => $userId
        ]);
    }
}