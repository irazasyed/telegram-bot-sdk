<?php

namespace Telegram\Bot;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\HttpClientInterface;

/**
 * Class Api.
 *
 * @mixin Commands\CommandBus
 */
class Api
{
    use Events\EmitsEvents,
        Traits\Http,
        Traits\CommandsHandler,
        Traits\HasContainer;

    use Methods\Chat,
        Methods\EditMessage,
        Methods\Game,
        Methods\Get,
        Methods\Message,
        Methods\Query,
        Methods\Update;

    /** @var string Version number of the Telegram Bot PHP SDK. */
    const VERSION = '3.0.0';

    /** @var string The name of the environment variable that contains the Telegram Bot API Access Token. */
    const BOT_TOKEN_ENV_NAME = 'TELEGRAM_BOT_TOKEN';

    /**
     * Instantiates a new Telegram super-class object.
     *
     *
     * @param string                   $token                 The Telegram Bot API Access Token.
     * @param bool                     $async                 (Optional) Indicates if the request to Telegram
     *                                                        will be asynchronous (non-blocking).
     * @param HttpClientInterface|null $httpClientHandler     (Optional) Custom HTTP Client Handler.
     *
     * @throws TelegramSDKException
     */
    public function __construct($token = null, $async = false, $httpClientHandler = null)
    {
        $this->accessToken = $token ?? getenv(static::BOT_TOKEN_ENV_NAME);
        if (!$this->accessToken) {
            throw TelegramSDKException::tokenNotProvided(static::BOT_TOKEN_ENV_NAME);
        }

        $this->setAsyncRequest($async);
        $this->httpClientHandler = $httpClientHandler;
    }

    /**
     * Invoke Bots Manager.
     *
     * @param $config
     *
     * @return BotsManager
     */
    public static function manager($config): BotsManager
    {
        return new BotsManager($config);
    }

    /**
     * Magic method to process any dynamic method calls.
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }

        if (preg_match('/^\w+Commands?/', $method, $matches)) {
            return call_user_func_array([$this->getCommandBus(), $matches[0]], $arguments);
        }

        throw new \BadMethodCallException("Method [$method] does not exist.");
    }
}
