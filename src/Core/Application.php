<?php

namespace Draguo\Dingtalk\Core;

use Draguo\Dingtalk\Contacts\User;
use Draguo\Dingtalk\QrConnect\Socialite;
use Draguo\Dingtalk\Supports\Config;

class Application
{
    public $config;

    public function __construct($config)
    {
        $this->config = new Config($config);
    }

    public function socialite($app)
    {
        $appId = $this->config->get("socialite.{$app}.appid");
        $appSecret = $this->config->get("socialite.{$app}.appserect");
        return new Socialite($appId, $appSecret);
    }

    public function user()
    {
        $token = new AccessToken($this);
        return new User($token->getAccessToken());
    }

    public function microapp($name = 'default')
    {
        $token = new AccessToken($this);
        return new Microapp($token->getAccessToken(), $name, $this->config);
    }
}