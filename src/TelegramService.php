<?php

namespace Telegram\Bot;

use BadMethodCallException;
use Illuminate\Support\Traits\Macroable;
use Telegram\Bot\Exceptions\TelegramException;
use Telegram\Bot\HttpClients\HttpClientInterface;

/**
 * Class TelegramService.
 *
 * @mixin Commands\CommandBus
 */
class TelegramService
{
    use Macroable {
        __call as macroCall;
    }

    use Traits\Http;
    use Traits\CommandsHandler;
    use Traits\HasContainer;

    use Methods\Chat;
    use Methods\Commands;
    use Methods\EditMessage;
    use Methods\Game;
    use Methods\Get;
    use Methods\Location;
    use Methods\Message;
    use Methods\Passport;
    use Methods\Payments;
    use Methods\Query;
    use Methods\Stickers;
    use Methods\Update;
    use Methods\ReplyKeyboardMarkup;

    /** @var string The name of the environment variable that contains the Telegram Bot API Access Token. */
    const BOT_TOKEN_ENV_NAME = 'TELEGRAM_BOT_TOKEN';

    /**
     * Instantiates a new Telegram super-class object.
     *
     *
     * @param string                   $token             The Telegram Bot API Access Token.
     * @param bool                     $async             (Optional) Indicates if the request to Telegram will be asynchronous (non-blocking).
     * @param HttpClientInterface|null $httpClientHandler (Optional) Custom HTTP Client Handler.
     *
     * @throws TelegramException
     */
    public function __construct($token = null, $async = false, $httpClientHandler = null)
    {
        $this->accessToken = $token ?? getenv(static::BOT_TOKEN_ENV_NAME);
        $this->validateAccessToken();

        if ($async) {
            $this->setAsyncRequest($async);
        }

        $this->httpClientHandler = $httpClientHandler;
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
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $arguments);
        }

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }

        //If the method does not exist on the API, try the commandBus.

        /* if (preg_match('/^\w+Command?/', $method, $matches)) {
            return call_user_func_array([$this->getCommandBus(), $matches[0]], $arguments);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");*/
    }

    /**
     * @throws TelegramException
     */
    private function validateAccessToken()
    {
        if (! $this->accessToken || ! is_string($this->accessToken)) {
            throw TelegramException::tokenNotProvided(static::BOT_TOKEN_ENV_NAME);
        }
    }
}
