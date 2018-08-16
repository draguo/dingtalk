<?php

namespace Draguo\Dingtalk\Message;

class Markdown extends Message
{
    protected $type = 'markdown';

    protected function formatParams($message)
    {
        return $message;
    }
}
