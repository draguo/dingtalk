<?php

namespace Draguo\Dingtalk\Contacts;

use Draguo\Dingtalk\Core\BaseClient;

class User extends BaseClient
{

    public function getUserIdByUnionId($unionId)
    {
        return $this->get('/user/getUseridByUnionid', [
            'access_token' => $this->getAccessToken(),
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
            'access_token' => $this->getAccessToken(),
            'userid' => $userId
        ]);
    }
}