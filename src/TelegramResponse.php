<?php

namespace Telegram\Bot;

use GuzzleHttp\Promise\PromiseInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class TelegramResponse.
 *
 * Handles the response from Telegram API.
 */
final class TelegramResponse
{
    /** @var null|int The HTTP status code response from API. */
    private ?int $httpStatusCode = null;

    /** @var array The headers returned from API request. */
    private array $headers = [];

    /** @var string The raw body of the response from API request. */
    private string $body;

    /** @var array|null The decoded body of the API response. */
    private ?array $decodedBody = null;

    /** @var string API Endpoint used to make the request. */
    private string $endPoint;

    /** @var TelegramSDKException The exception thrown by this request. */
    private TelegramSDKException $thrownException;

    /**
     * Gets the relevant data from the Http client.
     *
     * @param  ResponseInterface|PromiseInterface  $response
     */
    public function __construct(/** @var TelegramRequest The original request that returned this response. */
        private TelegramRequest $request, $response)
    {
        if ($response instanceof ResponseInterface) {
            $this->httpStatusCode = $response->getStatusCode();
            $this->body = $response->getBody();
            $this->headers = $response->getHeaders();

            $this->decodeBody();
        } elseif ($response instanceof PromiseInterface) {
            $this->httpStatusCode = null;
        } else {
            throw new InvalidArgumentException(
                'Second constructor argument "response" must be instance of ResponseInterface or PromiseInterface'
            );
        }
        $this->endPoint = $request->getEndpoint();
    }

    /**
     * Converts raw API response to proper decoded response.
     */
    public function decodeBody(): void
    {
        if ($this->body !== '' && $this->body !== '0') {
            $this->decodedBody = json_decode($this->body, true, 512, JSON_THROW_ON_ERROR);
        }

        if ($this->decodedBody === null) {
            $this->decodedBody = [];
            parse_str($this->body, $this->decodedBody);
        }

        if (! is_array($this->decodedBody)) {
            $this->decodedBody = [];
        }

        if ($this->isError()) {
            $this->makeException();
        }
    }

    /**
     * Checks if response is an error.
     */
    public function isError(): bool
    {
        return isset($this->decodedBody['ok']) && ($this->decodedBody['ok'] === false);
    }

    /**
     * Instantiates an exception to be thrown later.
     */
    public function makeException(): void
    {
        $this->thrownException = TelegramResponseException::create($this);
    }

    /**
     * Return the original request that returned this response.
     */
    public function getRequest(): TelegramRequest
    {
        return $this->request;
    }

    /**
     * Gets the HTTP status code.
     * Returns NULL if the request was asynchronous since we are not waiting for the response.
     */
    public function getHttpStatusCode(): ?int
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the Request Endpoint used to get the response.
     */
    public function getEndpoint(): string
    {
        return $this->endPoint;
    }

    /**
     * Return the bot access token that was used for this request.
     */
    public function getAccessToken(): ?string
    {
        return $this->request->getAccessToken();
    }

    /**
     * Return the HTTP headers for this response.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Return the raw body response.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Return the decoded body response.
     */
    public function getDecodedBody(): ?array
    {
        return $this->decodedBody;
    }

    /**
     * Helper function to return the payload of a successful response.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->decodedBody['result'] ?? false;
    }

    /**
     * Throws the exception.
     *
     * @return never
     *
     * @throws TelegramSDKException
     */
    public function throwException(): TelegramSDKException
    {
        throw $this->thrownException;
    }

    /**
     * Returns the exception that was thrown for this request.
     */
    public function getThrownException(): TelegramSDKException
    {
        return $this->thrownException;
    }
}
