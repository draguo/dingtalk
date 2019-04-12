<?php

namespace Draguo\Dingtalk\Core;

use Draguo\Dingtalk\Contacts\Department;
use Draguo\Dingtalk\Contacts\User;
use Draguo\Dingtalk\QrConnect\Socialite;
use Draguo\Dingtalk\SmartWork\Employee;
use Draguo\Dingtalk\Supports\Config;

class Application
{
    public $config;
    public $app = 'default';

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
        $this->app = $name;
        $token = new AccessToken($this);
        return new Microapp($token->getAccessToken(), $name, $this->config);
    }

    public function employee()
    {
        $token = new AccessToken($this);
        return new Employee($token->getAccessToken());
    }

    public function department()
    {
        $token = new AccessToken($this);
        return new Department($token->getAccessToken());
    }
}