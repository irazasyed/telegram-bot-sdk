<?php

namespace Telegram\Bot;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\HttpClientInterface;
use Telegram\Bot\Keyboard\Keyboard;

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
        $this->accessToken = $token ?: getenv(static::BOT_TOKEN_ENV_NAME);
        if ( ! $this->accessToken) {
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
    public static function manager($config)
    {
        return new BotsManager($config);
    }

    /**
     * Hide the current custom keyboard and display the default letter-keyboard.
     *
     * <code>
     * $params = [
     *   'hide_keyboard' => true,
     *   'selective'     => false,
     * ];
     * </code>
     *
     * @deprecated Use Telegram\Bot\Keyboard\Keyboard::hide(array $params = []) instead.
     *             To be removed in next major version.
     *
     * @link       https://core.telegram.org/bots/api#replykeyboardhide
     *
     * @param array $params
     *
     * @var bool    $params ['hide_keyboard']
     * @var bool    $params ['selective']
     *
     * @return string
     */
    public static function replyKeyboardHide(array $params = [])
    {
        return Keyboard::hide($params);
    }

    /**
     * Display a reply interface to the user (act as if the user has selected the bot‘s message and tapped ’Reply').
     *
     * <code>
     * $params = [
     *   'force_reply' => true,
     *   'selective'   => false,
     * ];
     * </code>
     *
     * @deprecated Use Telegram\Bot\Keyboard\Keyboard::forceReply(array $params = []) instead.
     *             To be removed in next major version.
     *
     * @link       https://core.telegram.org/bots/api#forcereply
     *
     * @param array $params
     *
     * @var bool    $params ['force_reply']
     * @var bool    $params ['selective']
     *
     * @return Keyboard
     */
    public static function forceReply(array $params = [])
    {
        return Keyboard::forceReply($params);
    }

    /**
     * Builds a custom keyboard markup.
     *
     * <code>
     * $params = [
     *   'keyboard'          => '',
     *   'resize_keyboard'   => '',
     *   'one_time_keyboard' => '',
     *   'selective'         => '',
     * ];
     * </code>
     *
     * @deprecated Use Telegram\Bot\Keyboard\Keyboard::make(array $params = []) instead.
     *             To be removed in next major version.
     *
     * @link       https://core.telegram.org/bots/api#replykeyboardmarkup
     *
     * @param array $params
     *
     * @var array   $params ['keyboard']
     * @var bool    $params ['resize_keyboard']
     * @var bool    $params ['one_time_keyboard']
     * @var bool    $params ['selective']
     *
     * @return string
     */
    public function replyKeyboardMarkup(array $params)
    {
        return Keyboard::make($params);
    }

    /**
     * @deprecated Call method isType directly on Message object
     *             To be removed in next major version.
     *
     */
    public function isMessageType($type, $object)
    {
        trigger_error('This method has been deprecated. Use isType() on the Message object instead.',
            E_USER_DEPRECATED);
    }

    /**
     * @deprecated Call method detectType directly on Message object
     *             To be removed in next major version.
     */
    public function detectMessageType($object)
    {
        trigger_error('This method has been deprecated. Use detectType() on the Message object instead.',
            E_USER_DEPRECATED);
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
