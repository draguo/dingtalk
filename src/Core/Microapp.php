<?php
/**
 * author: draguo
 */

namespace Draguo\Dingtalk\Core;


use Draguo\Dingtalk\Message\Message;
use Draguo\Dingtalk\Message\Text;
use Draguo\Dingtalk\Supports\Config;

class Microapp extends BaseClient
{
    protected $agentId;
    protected $params = [];

    public function __construct($token, $name, Config $config)
    {
        parent::__construct($token);
        $this->agentId = $config->get("app.{$name}.agentId");
    }

    // 相同内容对同一个用户发送有频率限制
    public function send($message)
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        if (!$message instanceof Message) {
            throw new Exception('params must instanceof message');
        }

        return $this->postJson('/topapi/message/corpconversation/asyncsend_v2?access_token=' .
            $this->getAccessToken(), array_merge([
            'agent_id' => $this->agentId,
            'msg' => $message->getParams(),
        ], $this->params));
    }

    /**
     * 默认是个人列表
     * @param $users
     * @return $this
     * ['userid_list' => '', 'dept_id_list' => '', 'to_all_user' => $this->toAllUser]
     */
    public function to($users)
    {
        // todo to all
        if (is_string($users)) {
            $this->params = [
                'userid_list' => $users,
            ];
        } else {
            $this->params = $users;
        }

        return $this;
    }
}