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
        $this->appId = $application->config->get('corpid');
        $this->appSecret = $application->config->get('corpsecret');
        return $this;
    }

    public function getAccessToken()
    {
        if (!$this->accessToken) {
            $response = $this->get('/gettoken', ['corpid' => $this->appId, 'corpsecret' => $this->appSecret]);
            $this->accessToken = $response['access_token'];
        }
        return $this->accessToken;
    }
}