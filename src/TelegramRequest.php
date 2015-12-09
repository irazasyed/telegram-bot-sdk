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
    /**
     * @var string|null The bot access token to use for this request.
     */
    protected $accessToken;

    /**
     * @var string The HTTP method for this request.
     */
    protected $method;

    /**
     * @var string The API endpoint for this request.
     */
    protected $endpoint;

    /**
     * @var array The headers to send with this request.
     */
    protected $headers = [];

    /**
     * @var array The parameters to send with this request.
     */
    protected $params = [];

    /**
     * @var array Special parameters for HttpClient.
     */
    protected $httpClientParams = [];

    /**
     * @var array The files to send with this request.
     */
    protected $files = [];

    /**
     * Indicates if the request to Telegram will be asynchronous (non-blocking).
     *
     * @var bool
     */
    protected $isAsyncRequest = false;

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
        $this->setHttpClientParams($params);
        $this->setAsyncRequest($isAsyncRequest);
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
     * Return the bot access token for this request.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
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
     * Return the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
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
     * Return the API Endpoint for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
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
        $params = self::filterParams($params, 'http_client_', false);
        $this->params = array_merge($this->params, $params);

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
     * Filter parameters for HttpClient.
     *
     * @param array $params
     *
     * @return $this
     */
    public function setHttpClientParams(array $params)
    {
        $params = self::filterParams($params, 'http_client_', true);
        $this->httpClientParams = array_merge($this->httpClientParams, $params);

        return $this;
    }

    /**
     * Return special HttpClient params for this request.
     *
     * @return array
     */
    public function getHtpClientParams()
    {
        return $this->httpClientParams;
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
     * Filter parameters with prefix (keep or remove them from array).
     *
     * @param array     $params
     * @param string    $prefix
     * @param bool|true $keep
     *
     * @return array
     */
    private static function filterParams(array $params, $prefix, $keep = true)
    {
        $mainKey = array_keys($params)[0];
        $result = [];
        foreach ($params[$mainKey] as $key => $value) {
            $pos = strpos($key, $prefix);
            if ($keep && $pos === 0) {
                $key = substr($key, strlen($prefix));
                $result[$key] = $value;
            } elseif (!$keep && $pos !== 0) {
                $result[$key] = $value;
            }
        }

        return $keep ? $result : [$mainKey => $result];
    }
}
