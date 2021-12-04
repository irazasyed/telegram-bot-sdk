<?php

namespace Telegram\Bot\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use App\Exceptions\TelegramRateLimitedException;
use App\Exceptions\TelegramUserBlockedTheBotException;
use App\Exceptions\TelegramUserDeactivatedException;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Illuminate\Support\Facades\Cache;
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
    )
    {
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
            $userId = $options['form_params']['chat_id'] ?? $options['multipart'][0]['contents'] ?? null;

            if ($retry = Str::match('~retry after (\d+)~', $body = $response->getBody())) {
                throw new TelegramRateLimitedException($retry, 'Too many requests');
            }

            if (str_contains($body, 'blocked by the user')) {
                throw new TelegramUserBlockedTheBotException($userId, 'User blocked the Bot');
            }

            if (str_contains($body, 'user is deactivated')) {
                throw new TelegramUserDeactivatedException($userId, 'User is deactivated');
            }

            array_push($options, $url);

            Cache::store('file')->put('telegram.sdk.catch', $options);

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
     * @param bool $isAsyncRequest
     *
     * @return array
     */
    private function getOptions(
        array $headers,
        $body,
        $options,
        $isAsyncRequest = false,
        $proxy = null
    ): array
    {
        $default_options = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::BODY => $body,
            RequestOptions::TIMEOUT => $this->getTimeOut(),
            RequestOptions::CONNECT_TIMEOUT => $this->getConnectTimeOut(),
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
