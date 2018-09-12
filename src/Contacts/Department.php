<?php
/**
 * author: draguo
 */

namespace Draguo\Dingtalk\Contacts;


use Draguo\Dingtalk\Core\BaseClient;

class Department extends BaseClient
{
    public function all()
    {
        return $this->get('department/list', [
            'access_token' => $this->getAccessToken(),
            'fetch_child' => true,
            'id' => 1
        ])['department'];
    }
}