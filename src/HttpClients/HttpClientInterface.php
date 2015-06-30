<?php

namespace Irazasyed\Telegram\HttpClients;

interface HttpClientInterface
{
    public function send($url, $method, array $headers = [], array $options = [], $timeOut = 30, $isAsyncRequest = false);
}