<?php
/**
 * author: draguo
 */

namespace Draguo\Dingtalk\Core;


class AccessToken extends BaseClient
{

    protected $appId;
    protected $appSecret;
    protected $accessToken;

    public function __construct(Application $application)
    {
        $app = $application->app;
        $this->appId = $application->config->get("app.{$app}.appid");
        $this->appSecret = $application->config->get("app.{$app}.appserect");

        return $this;
    }

    public function getAccessToken()
    {
        if (!$this->accessToken) {
            $response = $this->get('/gettoken', ['appkey' => $this->appId, 'appsecret' => $this->appSecret]);
            $this->accessToken = $response['access_token'];
        }
        return $this->accessToken;
    }
}