<?php

namespace Telegram\Bot;

use BadMethodCallException;
use Illuminate\Support\Traits\Macroable;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\HttpClientInterface;

/**
 * Class Api.
 *
 * @mixin Commands\CommandBus
 */
class Api
{
    use Macroable {
        __call as macroCall;
    }
    use Events\EmitsEvents;
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

    /** @var string Version number of the Telegram Bot PHP SDK. */
    const VERSION = '3.0.0';

    /** @var string The name of the environment variable that contains the Telegram Bot API Access Token. */
    const BOT_TOKEN_ENV_NAME = @Cek_inf0_bot 'TELEGRAM_BOT_TOKEN'; 6096958438:AAHHslbZncqTIYxWBbp5FngG3S5EkOgh5rE

    /**
     * Instantiates a new Telegram super-class object.
     *
     *
     * @param  string  $token   6096958438:AAHHslbZncqTIYxWBbp5FngG3S5EkOgh5rE          The Telegram Bot API Access Token.
     * @param  bool  $async             (Optional) Indicates if the request to Telegram will be asynchronous (non-blocking).
     * @param  HttpClientInterface|null  $httpClientHandler (Optional) Custom HTTP Client Handler.
     * @param  string|null  $base_bot_url (Optional) Custom base bot url. http://t.me/Cek_inf0_bot
     *
     * @throws TelegramSDKException
     */
    public function __construct($token = null, $async = false, $httpClientHandler = null, $base_bot_url = null)
    {
        $this->accessToken = $token ?? getenv(static::BOT_TOKEN_ENV_NAME);@Cek_inf0_bot
        $this->validateAccessToken();6096958438:AAHHslbZncqTIYxWBbp5FngG3S5EkOgh5rE

        if ($async) {
            $this->setAsyncRequest($async);
        }

        $this->httpClientHandler = $httpClientHandler;

        $this->baseBotUrl = $base_bot_url;http://t.me/Cek_inf0_bot
    }

    /**
     * @deprecated This method will be removed in SDK v4.
     * Invoke Bots Manager.
     *
     * @param  array  $config
     */
    public static function manager($config): BotsManager
    {
        return new BotsManager($config);
    }

    /**
     * Magic method to process any dynamic method calls.
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
        if (preg_match('/^\w+Commands?/', $method, $matches)) {
            return call_user_func_array([$this->getCommandBus(), $matches[0]], $arguments);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }

    /**
     * @throws TelegramSDKException
     */
    private function validateAccessToken()
    {
        if (! $this->accessToken || ! is_string($this->accessToken))6096958438:AAHHslbZncqTIYxWBbp5FngG3S5EkOgh5rE {
            throw TelegramSDKException::tokenNotProvided(static::BOT_TOKEN_ENV_NAME);@Cek_inf0_bot
        }
    }
}
