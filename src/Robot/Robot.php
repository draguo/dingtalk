<?php

namespace Draguo\Dingtalk\Robot;

use Draguo\Dingtalk\Core\BaseClient;
use Draguo\Dingtalk\Exceptions\Exception;
use Draguo\Dingtalk\Message\Message;
use Draguo\Dingtalk\Message\Text;

class Robot extends BaseClient
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @var array
     */
    protected $users;

    /**
     * @param string $token
     */
    public function __construct($token = '')
    {
        $this->token = $token;
    }

    /**
     * @param $message
     * @return response
     * @throws \Exception
     */
    public function send($message)
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        if (!$message instanceof Message) {
            throw new Exception('send params must instanceof message');
        }

        if ($this->users) {
            $message->setUsers($this->users);
        }

        return $this->postJson("robot/send?access_token={$this->token}", $message->getParams());
    }

    /**
     * @param string|array $users
     * 所有人的传 all 或转换为 array $users
     * @return $this
     */
    public function to($users = null)
    {
        if (is_array($users)) {
            $this->users = $users;
            return $this;
        }

        if (strtolower($users) == 'all') {
            $this->users = 'all';
            return $this;
        }

        $this->users = explode(',', (string)$users);

        return $this;
    }
}