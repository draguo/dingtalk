<?php
/**
 * author: draguo
 */

namespace Draguo\Dingtalk\Contacts;


use Draguo\Dingtalk\Core\BaseClient;

class Department extends BaseClient
{
    public function all($ids = [1])
    {
        $departments = [];

        foreach ($ids as $key => $department) {
            $r = $this->find($department);
            unset($ids[$key]);
            $departments = array_merge($departments, $r);
            $ids = array_column($r, 'id');
            if (!empty($ids)) {
                $departments = array_merge($departments, $this->all($ids));
            }
        }

        return $departments;
    }

    public function find($id = 1)
    {
        return $this->get('department/list', [
            'access_token' => $this->getAccessToken(),
            'fetch_child' => true,
            'id' => $id
        ])['department'];
    }
}