<?php

namespace Draguo\Dingtalk\QrConnect;

use Draguo\Dingtalk\Core\BaseClient;

class Socialite extends BaseClient
{

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * Socialite constructor.
     * @param $appId string
     * @param $appSecret string
     */
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    /**
     * @param $url
     * @return string
     * 跳转单独页面扫码方式
     * $url 需自行编码
     */
    public function getRedirectUrl($url)
    {
        return "{$this->baseUri}/connect/qrconnect?" . http_build_query([
                'appid' => $this->appId,
                'response_type' => 'code',
                'scope' => 'snsapi_login',
            ]) . "&redirect_uri={$url}";
    }

    public function getUserInfoByCode($tmp_auth_code)
    {
        $timestamp = round(microtime(true) * 1000);
        $response = $this->postJson("/sns/getuserinfo_bycode?signature={$this->getSignature($timestamp)}&timestamp={$timestamp}&accessKey={$this->appId}",
            compact('tmp_auth_code')
        );

        return $response['user_info'];
    }

    // 根据timestamp, appSecret计算签名值
    private function getSignature($timestamp)
    {
        $s = hash_hmac('sha256', $timestamp, $this->appSecret, true);
        $signature = base64_encode($s);
        return urlencode($signature);
    }
}