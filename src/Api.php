<?php

namespace Telegram\Bot;

use League\Event\EventDispatcher;
use Telegram\Bot\Events\EmitsEvents;
use Telegram\Bot\Traits\Http;
use Telegram\Bot\Traits\CommandsHandler;
use Telegram\Bot\Traits\HasContainer;
use Telegram\Bot\Methods\Chat;
use Telegram\Bot\Methods\Commands;
use Telegram\Bot\Methods\EditMessage;
use Telegram\Bot\Methods\Game;
use Telegram\Bot\Methods\Get;
use Telegram\Bot\Methods\Location;
use Telegram\Bot\Methods\Message;
use Telegram\Bot\Methods\Passport;
use Telegram\Bot\Methods\Payments;
use Telegram\Bot\Methods\Query;
use Telegram\Bot\Methods\Stickers;
use Telegram\Bot\Methods\Update;
use BadMethodCallException;
use Illuminate\Support\Traits\Macroable;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\HttpClientInterface;
use Telegram\Bot\Commands\CommandBus;

/**
 * Class Api.
 *
 * @mixin CommandBus
 */
class Api
{
    use Macroable {
        __call as macroCall;
    }
    use EmitsEvents;
    use Http;
    use CommandsHandler;
    use HasContainer;
    use Chat;
    use Commands;
    use EditMessage;
    use Game;
    use Get;
    use Location;
    use Message;
    use Passport;
    use Payments;
    use Query;
    use Stickers;
    use Update;

    /** @var string Version number of the Telegram Bot PHP SDK. */
    public const VERSION = '3.10.0';

    /** @var string The name of the environment variable that contains the Telegram Bot API Access Token. */
    public const BOT_TOKEN_ENV_NAME = 'TELEGRAM_BOT_TOKEN';

    /**
     * Instantiates a new Telegram super-class object.
     *
     *
     * @param string|null $token The Telegram Bot API Access Token.
     * @param bool $async (Optional) Indicates if the request to Telegram will be asynchronous (non-blocking).
     * @param HttpClientInterface|null $httpClientHandler (Optional) Custom HTTP Client Handler.
     * @param string|null $baseBotUrl (Optional) Custom base bot url.
     *
     * @throws TelegramSDKException
     */
    public function __construct(string $token = null, bool $async = false, HttpClientInterface $httpClientHandler = null, string $baseBotUrl = null)
    {
        $this->accessToken = $token ?? getenv(self::BOT_TOKEN_ENV_NAME);
        $this->validateAccessToken();

        if ($async) {
            $this->setAsyncRequest($async);
        }

        $this->httpClientHandler = $httpClientHandler;

        $this->baseBotUrl = $baseBotUrl;
    }

    /**
     * @deprecated This method will be removed in SDK v4.
     * Invoke Bots Manager.
     */
    public static function manager(array $config): BotsManager
    {
        return new BotsManager($config);
    }

    /**
     * Magic method to process any dynamic method calls.
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (self::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $parameters);
        }

        //If the method does not exist on the API, try the commandBus.
        if (preg_match('#^\w+Commands?#', $method, $matches)) {
            return call_user_func_array([$this->getCommandBus(), $matches[0]], $parameters);
        }

        throw new BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
    }

    /**
     * @throws TelegramSDKException
     */
    private function validateAccessToken(): void
    {
        if (!$this->accessToken) {
            throw TelegramSDKException::tokenNotProvided(self::BOT_TOKEN_ENV_NAME);
        }
    }
}
