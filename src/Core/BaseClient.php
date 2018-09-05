<?php

namespace Draguo\Dingtalk\Core;

use Draguo\Dingtalk\Supports\HasHttpRequest;

abstract class BaseClient
{
    protected $baseUri = 'https://oapi.dingtalk.com';

    use HasHttpRequest;
    protected $accessToken;

    // 单个 app 可用，和企业调用的 access_token 不一样
    public function getAccessToken($appId, $appSecret)
    {
        if (!$this->accessToken) {
            $response = $this->get('/gettoken', ['corpid' => $appId, 'corpsecret' => $appSecret]);
            $this->accessToken = $response['access_token'];
        }
        return $this->accessToken;
    }
}