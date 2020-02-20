<?php

namespace Telegram\Bot;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\GuzzleHttpClient;
use Telegram\Bot\HttpClients\HttpClientInterface;

/**
 * Class TelegramClient.
 */
class TelegramClient
{
    /** @var string Telegram Bot API URL. */
    const BASE_BOT_URL = 'https://api.telegram.org/bot';

    /** @var HttpClientInterface|null HTTP Client. */
    protected $httpClientHandler;

    /**
     * Instantiates a new TelegramClient object.
     *
     * @param HttpClientInterface|null $httpClientHandler
     */
    public function __construct(HttpClientInterface $httpClientHandler = null)
    {
        $this->httpClientHandler = $httpClientHandler ?? new GuzzleHttpClient();
    }

    /**
     * Returns the HTTP client handler.
     *
     * @return HttpClientInterface
     */
    public function getHttpClientHandler()
    {
        return $this->httpClientHandler;
    }

    /**
     * Sets the HTTP client handler.
     *
     * @param HttpClientInterface $httpClientHandler
     *
     * @return TelegramClient
     */
    public function setHttpClientHandler(HttpClientInterface $httpClientHandler): self
    {
        $this->httpClientHandler = $httpClientHandler;

        return $this;
    }

    /**
     * Send an API request and process the result.
     *
     * @param TelegramRequest $request
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    public function sendRequest(TelegramRequest $request): TelegramResponse
    {
        [$url, $method, $headers, $isAsyncRequest] = $this->prepareRequest($request);

        $options = $this->getOption($request, $method);

        $rawResponse = $this->getHttpClientHandler()
            ->setTimeOut($request->getTimeOut())
            ->setConnectTimeOut($request->getConnectTimeOut())
            ->send(
                $url,
                $method,
                $headers,
                $options,
                $isAsyncRequest
            );

        $returnResponse = $this->getResponse($request, $rawResponse);

        if ($returnResponse->isError()) {
            throw $returnResponse->getThrownException();
        }

        return $returnResponse;
    }

    /**
     * Prepares the API request for sending to the client handler.
     *
     * @param TelegramRequest $request
     *
     * @return array
     */
    public function prepareRequest(TelegramRequest $request): array
    {
        $url = $this->getBaseBotUrl().$request->getAccessToken().'/'.$request->getEndpoint();

        return [
            $url,
            $request->getMethod(),
            $request->getHeaders(),
            $request->isAsyncRequest(),
        ];
    }

    /**
     * Returns the base Bot URL.
     *
     * @return string
     */
    public function getBaseBotUrl(): string
    {
        return static::BASE_BOT_URL;
    }

    /**
     * Creates response object.
     *
     * @param TelegramRequest                    $request
     * @param ResponseInterface|PromiseInterface $response
     *
     * @return TelegramResponse
     */
    protected function getResponse(TelegramRequest $request, $response): TelegramResponse
    {
        return new TelegramResponse($request, $response);
    }

    /**
     * @param TelegramRequest $request
     * @param $method
     *
     * @return array
     */
    private function getOption(TelegramRequest $request, $method)
    {
        if ($method === 'POST') {
            return $request->getPostParams();
        }

        return ['query' => $request->getParams()];
    }
}
