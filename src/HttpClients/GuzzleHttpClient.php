<?php

namespace Telegram\Bot\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Throwable;

/**
 * Class GuzzleHttpClient.
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /** @var PromiseInterface[] Holds promises. */
    private static $promises = [];

    /** @var Client|ClientInterface HTTP client. */
    protected $client;

    /** @var int Timeout of the request in seconds. */
    protected $timeOut = 30;

    /** @var int Connection timeout of the request in seconds. */
    protected $connectTimeOut = 10;

    /**
     * GuzzleHttpClient constructor.
     *
     * @param ClientInterface|null $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?? new Client();
    }

    /**
     * Unwrap Promises.
     * @throws Throwable
     */
    public function __destruct()
    {
        Promise\unwrap(self::$promises);
    }

    /**
     * Sets HTTP client.
     *
     * @param ClientInterface $client
     *
     * @return GuzzleHttpClient
     */
    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * {@inheritdoc}
     * @throws TelegramSDKException
     */
    public function send(
        $url,
        $method,
        array $headers = [],
        array $options = [],
        $isAsyncRequest = false
    ) {
        $body = $options['body'] ?? null;
        $options = $this->getOptions($headers, $body, $options, $isAsyncRequest);

        try {
            $response = $this->getClient()->requestAsync($method, $url, $options);

            if ($isAsyncRequest) {
                self::$promises[] = $response;
            } else {
                $response = $response->wait();
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if (! $response instanceof ResponseInterface) {
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
     * @param array $options
     * @param bool  $isAsyncRequest
     *
     * @return array
     */
    private function getOptions(
        array $headers,
        $body,
        $options,
        $isAsyncRequest = false,
        $proxy = null
    ): array {
        $default_options = [
            RequestOptions::HEADERS         => $headers,
            RequestOptions::BODY            => $body,
            RequestOptions::TIMEOUT         => $this->getTimeOut(),
            RequestOptions::CONNECT_TIMEOUT => $this->getConnectTimeOut(),
            RequestOptions::SYNCHRONOUS     => ! $isAsyncRequest,
        ];

        if ($proxy !== null) {
            $default_options[RequestOptions::PROXY] = $proxy;
        }

        return array_merge($default_options, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeOut(): int
    {
        return $this->timeOut;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimeOut($timeOut): self
    {
        $this->timeOut = $timeOut;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnectTimeOut(): int
    {
        return $this->connectTimeOut;
    }

    /**
     * {@inheritdoc}
     */
    public function setConnectTimeOut($connectTimeOut): self
    {
        $this->connectTimeOut = $connectTimeOut;

        return $this;
    }

    /**
     * Gets HTTP client for internal class use.
     *
     * @return Client
     */
    private function getClient(): Client
    {
        return $this->client;
    }
}
