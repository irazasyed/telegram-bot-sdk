<?php

namespace Telegram\Bot\HttpClients;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface HttpClientInterface.
 */
interface HttpClientInterface
{
    /**
     * Send HTTP request.
     *
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param array $options
     * @param bool $isAsyncRequest
     * @return ResponseInterface|PromiseInterface|null
     */
    public function send(
        string $url,
        string $method,
        array  $headers = [],
        array  $options = [],
        bool $isAsyncRequest = false
    ): ResponseInterface|PromiseInterface|null;

    /**
     * Get Timeout.
     */
    public function getTimeOut(): int;

    /**
     * Set Timeout.
     *
     * @param int $timeOut
     * @return $this
     */
    public function setTimeOut(int $timeOut): static;

    /**
     * Get Connection Timeout.
     */
    public function getConnectTimeOut(): int;

    /**
     * Set Connection Timeout.
     *
     * @param int $connectTimeOut
     * @return $this
     */
    public function setConnectTimeOut(int $connectTimeOut): static;
}
