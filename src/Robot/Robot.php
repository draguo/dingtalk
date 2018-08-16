<?php

namespace Draguo\Dingtalk\Robot;

use Draguo\Dingtalk\Exceptions\BadRequestException;
use Draguo\Dingtalk\Exceptions\Exception;
use Draguo\Dingtalk\Message\Message;
use Draguo\Dingtalk\Message\Text;
use Draguo\Dingtalk\Supports\HasHttpRequest;

class Robot
{
    use HasHttpRequest;

    protected $baseUri = 'https://oapi.dingtalk.com';
    protected $token;
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
            throw new Exception('params must instanceof message');
        }

        if ($this->users) {
            $message->setUsers($this->users);
        }

        $response = $this->postJson('robot/send?access_token=' . $this->token, $message->getParams());

        if ($response['errcode'] != 0) {
            throw new BadRequestException(json_encode($response));
        }

        return $response;
    }

    /**
     * @param string|array $users
     * 所有人的传 all
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