<?php

namespace Draguo\Dingtalk\Message;

class Text extends Message
{
    protected $type = 'text';

    protected function formatParams($message)
    {
        return [
            'content' => $message
        ];
    }
}
