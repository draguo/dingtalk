<?php

namespace Draguo\Dingtalk\Core;

use Draguo\Dingtalk\Supports\HasHttpRequest;

class BaseClient
{
    protected $baseUri = 'https://oapi.dingtalk.com';

    use HasHttpRequest;
}