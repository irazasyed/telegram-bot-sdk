<?php

namespace Telegram\Bot\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Throwable;
use Illuminate\Support\Str;
use Telegram\Bot\Exceptions\TelegramUserBlockedException;
use Telegram\Bot\Exceptions\TelegramRateLimitedException;
use Telegram\Bot\Exceptions\TelegramUserDeactivatedException;

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
        } catch (GuzzleException $e) {
            $response = null;
            if ($e instanceof RequestExceptionInterface || $e instanceof RequestException) {
                $response = $e->getResponse();
                
                $this->throwRelatedForbiddenExceptionIfNeeded($response);
            }

            if (! $response instanceof ResponseInterface) {
                throw new TelegramSDKException($e->getMessage(), $e->getCode(), $e);
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
    
    
    /**
     * Determine if the user deactivated or blocked the bot then throw related exception
     * 
     * @param Response $response
     * @return void
     * @throws TelegramUserDeactivatedException|TelegramRateLimitedException|TelegramUserBlockedException
     */
    private function throwRelatedForbiddenExceptionIfNeeded(Response $response)
    {
        $code = $response->getStatusCode();
        $data = json_decode($response->getBody(), true);

        if ($code === 403) {
            $description = $data['description'];

            if (Str::contains($description, 'bot was blocked by the user')) {
                throw new TelegramUserBlockedException($description);
            }

            if (Str::contains($description, 'user is deactivated')) {
                throw new TelegramUserDeactivatedException($description);
            }
        }

        if ($code === 429) {
            throw new TelegramRateLimitedException($data['description'], $data['parameters']['retry_after']);
        }
    }
}
