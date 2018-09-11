<?php

namespace Draguo\Dingtalk\Core;

use Draguo\Dingtalk\Supports\HasHttpRequest;

abstract class BaseClient
{
    protected $baseUri = 'https://oapi.dingtalk.com';

    use HasHttpRequest;
    private $accessToken;

    public function __construct($token = null)
    {
        $this->setAccessToken($token);
    }

    /**
     * @param string $token
     */
    public function setAccessToken($token = '')
    {
        $this->accessToken = $token;
    }

    /**
     * @return null|string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
}