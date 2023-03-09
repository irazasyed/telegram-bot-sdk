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
     */
    public function send(
        string $url,
        string $method,
        array $headers = [],
        array $options = [],
        bool $isAsyncRequest = false
    ): ResponseInterface|PromiseInterface|null;

    /**
     * Get Timeout.
     */
    public function getTimeOut(): int;

    /**
     * Set Timeout.
     *
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
     * @return $this
     */
    public function setConnectTimeOut(int $connectTimeOut): static;
}
