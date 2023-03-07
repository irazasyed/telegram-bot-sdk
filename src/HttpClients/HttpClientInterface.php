<?php

namespace Telegram\Bot\HttpClients;

/**
 * Interface HttpClientInterface.
 */
interface HttpClientInterface
{
    /**
     * Send HTTP request.
     *
     * @param  string  $url
     * @param  string  $method
     * @param  bool|false  $isAsyncRequest
     * @return mixed
     */
    public function send(
        $url,
        $method,
        array $headers = [],
        array $options = [],
        $isAsyncRequest = false
    );

    /**
     * Get Timeout.
     */
    public function getTimeOut(): int;

    /**
     * Set Timeout.
     *
     * @param  int  $timeOut
     * @return $this
     */
    public function setTimeOut($timeOut);

    /**
     * Get Connection Timeout.
     */
    public function getConnectTimeOut(): int;

    /**
     * Set Connection Timeout.
     *
     * @param  int  $connectTimeOut
     * @return $this
     */
    public function setConnectTimeOut($connectTimeOut);
}
