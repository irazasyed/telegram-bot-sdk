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
class TelegramResponse
{
    /** @var null|int The HTTP status code response from API. */
    protected $httpStatusCode;

    /** @var array The headers returned from API request. */
    protected $headers;

    /** @var string The raw body of the response from API request. */
    protected $body;

    /** @var array The decoded body of the API response. */
    protected $decodedBody = [];

    /** @var string API Endpoint used to make the request. */
    protected $endPoint;

    /** @var TelegramRequest The original request that returned this response. */
    protected $request;

    /** @var TelegramSDKException The exception thrown by this request. */
    protected $thrownException;

    /**
     * Gets the relevant data from the Http client.
     *
     * @param TelegramRequest                    $request
     * @param ResponseInterface|PromiseInterface $response
     */
    public function __construct(TelegramRequest $request, $response)
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

        $this->request = $request;
        $this->endPoint = (string) $request->getEndpoint();
    }

    /**
     * Converts raw API response to proper decoded response.
     */
    public function decodeBody()
    {
        $this->decodedBody = json_decode($this->body, true);

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
     *
     * @return bool
     */
    public function isError(): bool
    {
        return isset($this->decodedBody['ok']) && ($this->decodedBody['ok'] === false);
    }

    /**
     * Instantiates an exception to be thrown later.
     */
    public function makeException()
    {
        $this->thrownException = TelegramResponseException::create($this);
    }

    /**
     * Return the original request that returned this response.
     *
     * @return TelegramRequest
     */
    public function getRequest(): TelegramRequest
    {
        return $this->request;
    }

    /**
     * Gets the HTTP status code.
     * Returns NULL if the request was asynchronous since we are not waiting for the response.
     *
     * @return null|int
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * Gets the Request Endpoint used to get the response.
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endPoint;
    }

    /**
     * Return the bot access token that was used for this request.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->request->getAccessToken();
    }

    /**
     * Return the HTTP headers for this response.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Return the raw body response.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Return the decoded body response.
     *
     * @return array
     */
    public function getDecodedBody(): array
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
        return $this->decodedBody['result'];
    }

    /**
     * Throws the exception.
     *
     * @throws TelegramSDKException
     */
    public function throwException(): TelegramSDKException
    {
        throw $this->thrownException;
    }

    /**
     * Returns the exception that was thrown for this request.
     *
     * @return TelegramSDKException
     */
    public function getThrownException(): TelegramSDKException
    {
        return $this->thrownException;
    }
}
