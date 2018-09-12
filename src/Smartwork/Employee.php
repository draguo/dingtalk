<?php
/**
 * author: draguo
 */

namespace Draguo\Dingtalk\SmartWork;

use Draguo\Dingtalk\Core\BaseClient;

class Employee extends BaseClient
{
    // 返回所有在职员工的 id
    public function all()
    {
        $ids = [];
        $offset = 0;
        do {
            $response = $this->post("/topapi/smartwork/hrm/employee/queryonjob?access_token={$this->getAccessToken()}", [
                'status_list' => '2,3,5,-1',
                'offset' => $offset,
                'size' => 50
            ]);
            $ids = array_merge($ids, $response['result']['data_list']);
            if (isset($response['result']['next_cursor'])) {
                $offset = $response['result']['next_cursor'];
            }
        } while (isset($response['result']['next_cursor']));

        return $ids;
    }

    public function users($userid_list,$field_filter_list)
    {
//        array_chunk()
    }

}