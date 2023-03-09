<?php

namespace Telegram\Bot;

use Telegram\Bot\HttpClients\GuzzleHttpClient;
use Telegram\Bot\HttpClients\HttpClientInterface;

final class TelegramClient
{
    /**
     * @var string
     */
    public const BASE_BOT_URL = 'https://api.telegram.org/bot';

    private HttpClientInterface $httpClientHandler;

    private string $baseBotUrl;

    public function __construct(HttpClientInterface $httpClientHandler = null, string $baseBotUrl = null)
    {
        $this->httpClientHandler = $httpClientHandler ?? new GuzzleHttpClient();
        $this->baseBotUrl = $baseBotUrl ?? self::BASE_BOT_URL;
    }

    public function getHttpClientHandler(): HttpClientInterface
    {
        return $this->httpClientHandler ?? new GuzzleHttpClient();
    }

    public function setHttpClientHandler(HttpClientInterface $httpClientHandler): self
    {
        $this->httpClientHandler = $httpClientHandler;

        return $this;
    }

    public function sendRequest(TelegramRequest $request): TelegramResponse
    {
        [$url, $method, $headers, $isAsyncRequest] = $this->prepareRequest($request);
        $options = $this->getOptions($request, $method);

        $rawResponse = $this->httpClientHandler
            ->setTimeOut($request->getTimeOut())
            ->setConnectTimeOut($request->getConnectTimeOut())
            ->send($url, $method, $headers, $options, $isAsyncRequest);

        $response = $this->getResponse($request, $rawResponse);

        if ($response->isError()) {
            throw $response->getThrownException();
        }

        return $response;
    }

    public function prepareRequest(TelegramRequest $request): array
    {
        $url = $this->baseBotUrl.$request->getAccessToken().'/'.$request->getEndpoint();

        return [$url, $request->getMethod(), $request->getHeaders(), $request->isAsyncRequest()];
    }

    public function getBaseBotUrl(): string
    {
        return $this->baseBotUrl;
    }

    private function getResponse(TelegramRequest $request, $response): TelegramResponse
    {
        return new TelegramResponse($request, $response);
    }

    private function getOptions(TelegramRequest $request, string $method): array
    {
        return $method === 'POST' ? $request->getPostParams() : ['query' => $request->getParams()];
    }
}
