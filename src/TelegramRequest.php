<?php

namespace Telegram\Bot;

use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class TelegramRequest.
 *
 * Builds Telegram Bot API Request Entity.
 */
class TelegramRequest
{
    /** @var string|null The bot access token to use for this request. */
    protected $accessToken;

    /** @var string The HTTP method for this request. */
    protected $method;

    /** @var string The API endpoint for this request. */
    protected $endpoint;

    /** @var array The headers to send with this request. */
    protected $headers = [];

    /** @var array The parameters to send with this request. */
    protected $params = [];

    /** @var array The files to send with this request. */
    protected $files = [];

    /** @var bool Indicates if the request to Telegram will be asynchronous (non-blocking). */
    protected $isAsyncRequest = false;

    /** @var int Timeout of the request in seconds. */
    protected $timeOut;

    /** @var int Connection timeout of the request in seconds. */
    protected $connectTimeOut;

    /**
     * Creates a new Request entity.
     *
     * @param  string|null  $accessToken
     * @param  string|null  $method
     * @param  string|null  $endpoint
     * @param  array|null  $params
     * @param  bool  $isAsyncRequest
     */
    public function __construct(
        $accessToken = null,
        $method = null,
        $endpoint = null,
        array $params = [],
        $isAsyncRequest = false
    ) {
        $this->setAccessToken($accessToken);
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setParams($params);
        $this->setAsyncRequest($isAsyncRequest);
    }

    /**
     * Make this request asynchronous (non-blocking).
     *
     * @param  bool  $isAsyncRequest
     */
    public function setAsyncRequest($isAsyncRequest): self
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * Validate that bot access token exists for this request.
     *
     * @throws TelegramSDKException
     */
    public function validateAccessToken()
    {
        if (null === $this->getAccessToken()) {
            throw new TelegramSDKException('You must provide your bot access token to make any API requests.');
        }
    }

    /**
     * Return the bot access token for this request.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set the bot access token for this request.
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Validate that the HTTP method is set.
     *
     * @throws TelegramSDKException
     */
    public function validateMethod()
    {
        if (! $this->method) {
            throw new TelegramSDKException('HTTP method not specified.');
        }

        if (! in_array($this->method, ['GET', 'POST'])) {
            throw new TelegramSDKException('Invalid HTTP method specified. Must be GET or POST');
        }
    }

    /**
     * Return the API Endpoint for this request.
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * Set the endpoint for this request.
     */
    public function setEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Return the headers for this request.
     */
    public function getHeaders(): array
    {
        $headers = $this->getDefaultHeaders();

        return array_merge($this->headers, $headers);
    }

    /**
     * Set the headers for this request.
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * The default headers used with every request.
     */
    public function getDefaultHeaders(): array
    {
        return [
            'User-Agent' => 'Telegram Bot PHP SDK v'.Api::VERSION.' (https://github.com/irazasyed/telegram-bot-sdk)',
        ];
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     */
    public function isAsyncRequest(): bool
    {
        return $this->isAsyncRequest;
    }

    /**
     * Only return params on POST requests.
     */
    public function getPostParams(): array
    {
        if ($this->getMethod() === 'POST') {
            return $this->getParams();
        }

        return [];
    }

    /**
     * Return the HTTP method for this request.
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set the HTTP method for this request.
     *
     * @param string
     */
    public function setMethod(string $method): self
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * Return the params for this request.
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Set the params for this request.
     */
    public function setParams(array $params = []): self
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * Get Timeout.
     */
    public function getTimeOut(): int
    {
        return $this->timeOut;
    }

    /**
     * Set Timeout.
     */
    public function setTimeOut(int $timeOut): self
    {
        $this->timeOut = $timeOut;

        return $this;
    }

    /**
     * Get Connection Timeout.
     */
    public function getConnectTimeOut(): int
    {
        return $this->connectTimeOut;
    }

    /**
     * Set Connection Timeout.
     */
    public function setConnectTimeOut(int $connectTimeOut): self
    {
        $this->connectTimeOut = $connectTimeOut;

        return $this;
    }
}
