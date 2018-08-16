<?php

namespace Draguo\Dingtalk\Message;

interface MessageInterface
{
    public function getParams();

    public function setUsers($users);
}
