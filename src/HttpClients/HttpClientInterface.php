<?php

namespace Telegram\Bot\HttpClients;

/**
 * Interface HttpClientInterface
 *
 * @package Telegram\Bot\HttpClients
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
