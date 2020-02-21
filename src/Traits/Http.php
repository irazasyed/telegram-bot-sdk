<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Exceptions\CouldNotUploadInputFile;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\HttpClients\HttpClientInterface;
use Telegram\Bot\TelegramClient;
use Telegram\Bot\TelegramRequest;
use Telegram\Bot\TelegramResponse;

/**
 * Http.
 */
trait Http
{
    use Validator;

    /** @var string Telegram Bot API Access Token. */
    protected $accessToken = null;

    /** @var TelegramClient The Telegram client service. */
    protected $client = null;

    /** @var HttpClientInterface|null Http Client Handler */
    protected $httpClientHandler = null;

    /** @var bool Indicates if the request to Telegram will be asynchronous (non-blocking). */
    protected $isAsyncRequest = false;

    /** @var int Timeout of the request in seconds. */
    protected $timeOut = 60;

    /** @var int Connection timeout of the request in seconds. */
    protected $connectTimeOut = 10;

    /** @var TelegramResponse|null Stores the last request made to Telegram Bot API. */
    protected $lastResponse;

    /**
     * Set Http Client Handler.
     *
     * @param HttpClientInterface $httpClientHandler
     *
     * @return $this
     */
    public function setHttpClientHandler(HttpClientInterface $httpClientHandler)
    {
        $this->httpClientHandler = $httpClientHandler;

        return $this;
    }

    /**
     * Returns the TelegramClient service.
     *
     * @return TelegramClient
     */
    protected function getClient(): TelegramClient
    {
        if ($this->client === null) {
            $this->client = new TelegramClient($this->httpClientHandler);
        }

        return $this->client;
    }

    /**
     * Returns the last response returned from API request.
     *
     * @return TelegramResponse|null
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Returns Telegram Bot API Access Token.
     *
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Sets the bot access token to use with API requests.
     *
     * @param string $accessToken The bot access token to save.
     *
     * @return $this
     */
    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     *
     * @return bool
     */
    public function isAsyncRequest(): bool
    {
        return $this->isAsyncRequest;
    }

    /**
     * Make this request asynchronous (non-blocking).
     *
     * @param bool $isAsyncRequest
     *
     * @return $this
     */
    public function setAsyncRequest(bool $isAsyncRequest)
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeOut(): int
    {
        return $this->timeOut;
    }

    /**
     * @param int $timeOut
     *
     * @return $this
     */
    public function setTimeOut(int $timeOut)
    {
        $this->timeOut = $timeOut;

        return $this;
    }

    /**
     * @return int
     */
    public function getConnectTimeOut(): int
    {
        return $this->connectTimeOut;
    }

    /**
     * @param int $connectTimeOut
     *
     * @return $this
     */
    public function setConnectTimeOut(int $connectTimeOut)
    {
        $this->connectTimeOut = $connectTimeOut;

        return $this;
    }

    /**
     * Sends a GET request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    protected function get(string $endpoint, array $params = []): TelegramResponse
    {
        $params = $this->replyMarkupToString($params);

        return $this->sendRequest('GET', $endpoint, $params);
    }

    /**
     * Sends a POST request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     * @param bool   $fileUpload Set true if a file is being uploaded.
     *
     * @throws TelegramSDKException
     * @return TelegramResponse
     */
    protected function post(string $endpoint, array $params = [], $fileUpload = false): TelegramResponse
    {
        $params = $this->normalizeParams($params, $fileUpload);

        return $this->sendRequest('POST', $endpoint, $params);
    }

    /**
     * Converts a reply_markup field in the $params to a string.
     *
     * @param array $params
     *
     * @return array
     */
    protected function replyMarkupToString(array $params): array
    {
        if (isset($params['reply_markup'])) {
            $params['reply_markup'] = (string) $params['reply_markup'];
        }

        return $params;
    }

    /**
     * Sends a multipart/form-data request to Telegram Bot API and returns the result.
     * Used primarily for file uploads.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $inputFileField
     *
     * @throws CouldNotUploadInputFile
     *
     * @return TelegramResponse
     */
    protected function uploadFile(string $endpoint, array $params, $inputFileField): TelegramResponse
    {
        //Check if the field in the $params array (that is being used to send the relative file), is a file id.
        if (! isset($params[$inputFileField])) {
            throw CouldNotUploadInputFile::missingParam($inputFileField);
        }

        if ($this->hasFileId($inputFileField, $params)) {
            return $this->post($endpoint, $params);
        }

        //Sending an actual file requires it to be sent using multipart/form-data
        return $this->post($endpoint, $this->prepareMultipartParams($params, $inputFileField), true);
    }

    /**
     * Prepare Multipart Params for File Upload.
     *
     * @param array  $params
     * @param string $inputFileField
     *
     * @throws CouldNotUploadInputFile
     *
     * @return array
     */
    protected function prepareMultipartParams(array $params, $inputFileField): array
    {
        $this->validateInputFileField($params, $inputFileField);

        //Iterate through all param options and convert to multipart/form-data.
        return collect($params)
            ->reject(function ($value) {
                return null === $value;
            })
            ->map(function ($contents, $name) {
                return $this->generateMultipartData($contents, $name);
            })
            ->values()
            ->all();
    }

    /**
     * Generates the multipart data required when sending files to telegram.
     *
     * @param mixed  $contents
     * @param string $name
     *
     * @return array
     */
    protected function generateMultipartData($contents, $name): array
    {
        if (! $this->isInputFile($contents)) {
            return compact('name', 'contents');
        }

        $filename = $contents->getFilename();
        $contents = $contents->getContents();

        return compact('name', 'contents', 'filename');
    }

    /**
     * Sends a request to Telegram Bot API and returns the result.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    protected function sendRequest($method, $endpoint, array $params = []): TelegramResponse
    {
        $telegramRequest = $this->resolveTelegramRequest($method, $endpoint, $params);

        return $this->lastResponse = $this->getClient()->sendRequest($telegramRequest);
    }

    /**
     * Instantiates a new TelegramRequest entity.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     *
     * @return TelegramRequest
     */
    protected function resolveTelegramRequest($method, $endpoint, array $params = []): TelegramRequest
    {
        return (new TelegramRequest(
            $this->getAccessToken(),
            $method,
            $endpoint,
            $params,
            $this->isAsyncRequest()
        ))
            ->setTimeOut($this->getTimeOut())
            ->setConnectTimeOut($this->getConnectTimeOut());
    }

    /**
     * @param array $params
     * @param $inputFileField
     *
     * @throws CouldNotUploadInputFile
     */
    protected function validateInputFileField(array $params, $inputFileField): void
    {
        if (! isset($params[$inputFileField])) {
            throw CouldNotUploadInputFile::missingParam($inputFileField);
        }

        // All file-paths, urls, or file resources should be provided by using the InputFile object
        if ((! $params[$inputFileField] instanceof InputFile) || (is_string($params[$inputFileField]) && ! $this->is_json($params[$inputFileField]))) {
            throw CouldNotUploadInputFile::inputFileParameterShouldBeInputFileEntity($inputFileField);
        }
    }

    /**
     * @param array $params
     * @param $fileUpload
     *
     * @return array
     */
    private function normalizeParams(array $params, $fileUpload)
    {
        if ($fileUpload) {
            return ['multipart' => $params];
        }

        return ['form_params' => $this->replyMarkupToString($params)];
    }
}
