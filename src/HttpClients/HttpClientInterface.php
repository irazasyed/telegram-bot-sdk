<?php

namespace Irazasyed\Telegram\HttpClients;

/**
 * Interface HttpClientInterface
 *
 * @package Irazasyed\Telegram\HttpClients
 */
interface HttpClientInterface
{
    /**
     * @param            $url
     * @param            $method
     * @param array      $headers
     * @param array      $options
     * @param int        $timeOut
     * @param bool|false $isAsyncRequest
     *
     * @return mixed
     */
    public function send(
        $url,
        $method,
        array $headers = [],
        array $options = [],
        $timeOut = 30,
        $isAsyncRequest = false
    );
}
