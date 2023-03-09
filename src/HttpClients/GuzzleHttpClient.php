<?php

namespace Telegram\Bot\HttpClients;

use function GuzzleHttp\Promise\unwrap;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Throwable;

/**
 * Class GuzzleHttpClient.
 */
final class GuzzleHttpClient implements HttpClientInterface
{
    /** @var PromiseInterface[] Holds promises. */
    private static array $promises = [];

    /** @var Client|ClientInterface HTTP client. */
    private ClientInterface $client;

    /** @var int Timeout of the request in seconds. */
    private int $timeOut = 30;

    /** @var int Connection timeout of the request in seconds. */
    private int $connectTimeOut = 10;

    /**
     * GuzzleHttpClient constructor.
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?? new Client();
    }

    /**
     * Unwrap Promises.
     *
     * @throws Throwable
     */
    public function __destruct()
    {
        unwrap(self::$promises);
    }

    /**
     * Sets HTTP client.
     */
    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
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
            $response = $this->client->requestAsync($method, $url, $options);

            if ($isAsyncRequest) {
                self::$promises[] = $response;
            } else {
                $response = $response->wait();
            }
        } catch (GuzzleException $guzzleException) {
            $response = null;
            if ($guzzleException instanceof RequestExceptionInterface || $guzzleException instanceof RequestException) {
                $response = $guzzleException->getResponse();
            }

            if (! $response instanceof ResponseInterface) {
                throw new TelegramSDKException($guzzleException->getMessage(), $guzzleException->getCode(), $guzzleException);
            }
        }

        return $response;
    }

    /**
     * Prepares and returns request options.
     *
     * @param  bool  $isAsyncRequest
     */
    private function getOptions(
        array $headers,
        $body,
        array $options,
        $isAsyncRequest = false,
        $proxy = null
    ): array {
        $default_options = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::BODY => $body,
            RequestOptions::TIMEOUT => $this->timeOut,
            RequestOptions::CONNECT_TIMEOUT => $this->connectTimeOut,
            RequestOptions::SYNCHRONOUS => ! $isAsyncRequest,
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
}
