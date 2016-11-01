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
     * @param string|null $accessToken
     * @param string|null $method
     * @param string|null $endpoint
     * @param array|null  $params
     * @param bool        $isAsyncRequest
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
     * @param $isAsyncRequest
     *
     * @return TelegramRequest
     */
    public function setAsyncRequest($isAsyncRequest)
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
        $accessToken = $this->getAccessToken();
        if ($accessToken === null) {
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
     *
     * @param string
     *
     * @return TelegramRequest
     */
    public function setAccessToken($accessToken)
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
        if (!$this->method) {
            throw new TelegramSDKException('HTTP method not specified.');
        }

        if (!in_array($this->method, ['GET', 'POST'])) {
            throw new TelegramSDKException('Invalid HTTP method specified.');
        }
    }

    /**
     * Return the API Endpoint for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set the endpoint for this request.
     *
     * @param string $endpoint
     *
     * @return TelegramRequest
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Return the headers for this request.
     *
     * @return array
     */
    public function getHeaders()
    {
        $headers = $this->getDefaultHeaders();

        return array_merge($this->headers, $headers);
    }

    /**
     * Set the headers for this request.
     *
     * @param array $headers
     *
     * @return TelegramRequest
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * The default headers used with every request.
     *
     * @return array
     */
    public function getDefaultHeaders()
    {
        return [
            'User-Agent' => 'Telegram Bot PHP SDK v'.Api::VERSION.' - (https://github.com/irazasyed/telegram-bot-sdk)',
        ];
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     *
     * @return bool
     */
    public function isAsyncRequest()
    {
        return $this->isAsyncRequest;
    }

    /**
     * Only return params on POST requests.
     *
     * @return array
     */
    public function getPostParams()
    {
        if ($this->getMethod() === 'POST') {
            return $this->getParams();
        }

        return [];
    }

    /**
     * Return the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the HTTP method for this request.
     *
     * @param string
     *
     * @return TelegramRequest
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * Return the params for this request.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set the params for this request.
     *
     * @param array $params
     *
     * @return TelegramRequest
     */
    public function setParams(array $params = [])
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    /**
     * Get Timeout.
     *
     * @return int
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * Set Timeout.
     *
     * @param int $timeOut
     *
     * @return $this
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $timeOut;

        return $this;
    }

    /**
     * Get Connection Timeout.
     *
     * @return int
     */
    public function getConnectTimeOut()
    {
        return $this->connectTimeOut;
    }

    /**
     * Set Connection Timeout.
     *
     * @param int $connectTimeOut
     *
     * @return $this
     */
    public function setConnectTimeOut($connectTimeOut)
    {
        $this->connectTimeOut = $connectTimeOut;

        return $this;
    }
}
