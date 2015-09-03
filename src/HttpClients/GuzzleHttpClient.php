<?php

namespace Irazasyed\Telegram\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Exception\RequestException;
use Irazasyed\Telegram\Exceptions\TelegramSDKException;

/**
 * Class GuzzleHttpClient
 *
 * @package Irazasyed\Telegram\HttpClients
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * @var PromiseInterface[]
     */
    private static $promises = [];


    /**
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * Unwrap Promises.
     */
    public function __destruct()
    {
        Promise\unwrap(self::$promises);
    }

    /**
     * Sets HTTP client.
     *
     * @param Client $client
     *
     * @return GuzzleHttpClient
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Gets HTTP client for internal class use.
     *
     * @return Client
     */
    private function getClient()
    {
        return $this->client;
    }

    /**
     * @inheritdoc
     */
    public function send(
        $url,
        $method,
        array $headers = [],
        array $options = [],
        $timeOut = 30,
        $isAsyncRequest = false
    ) {
        $body = isset($options['body']) ? $options['body'] : null;
        $options = $this->getOptions($headers, $body, $options, $timeOut, $isAsyncRequest);

        try {
            $response = $this->getClient()->requestAsync($method, $url, $options);

            if ($isAsyncRequest) {
                self::$promises[] = $response;
            } else {
                $response = $response->wait();
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $request = $e->getRequest();

            if (!$response instanceof ResponseInterface) {
                throw new TelegramSDKException($e->getMessage(), $e->getCode());
            }
        }

        return $response;
    }

    /**
     * Prepares and returns request options.
     *
     * @param array $headers
     * @param       $body
     * @param       $options
     * @param       $timeOut
     * @param       $isAsyncRequest
     *
     * @return array
     */
    private function getOptions(array $headers, $body, $options = [], $timeOut, $isAsyncRequest = false)
    {
        $default_options = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::BODY => $body,
            RequestOptions::TIMEOUT => $timeOut,
            RequestOptions::CONNECT_TIMEOUT => 10,
            RequestOptions::SYNCHRONOUS => !$isAsyncRequest,
        ];

        return array_merge($default_options, $options);
    }
}
