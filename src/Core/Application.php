<?php

namespace Draguo\Dingtalk\Core;

use Draguo\Dingtalk\Contacts\User;
use Draguo\Dingtalk\QrConnect\Socialite;
use Draguo\Dingtalk\Supports\Config;

class Application
{
    protected $config;

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

        $appId = $this->config->get('corpid');
        $appSecret = $this->config->get('corpsecret');
        return new User($appId, $appSecret);
    }
}