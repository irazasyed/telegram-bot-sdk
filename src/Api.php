<?php

namespace Telegram\Bot;

use Telegram\Bot\Events\EmitsEvents;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\HttpClientInterface;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\Http;
use Telegram\Bot\Traits\CommandsHandler;
use Telegram\Bot\Traits\HasContainer;
use Telegram\Bot\Methods\Factory as MethodsFactory;

/**
 * Class Api.
 *
 * @mixin Commands\CommandBus
 *
 * # Getting Updates
 * @method Methods\GetUpdates getUpdates(array $params = []) Use this method to receive incoming updates using long
 *         polling.
 * @method Methods\SetWebhook setWebhook(array $params = []) Set a Webhook to receive incoming updates via an outgoing
 *         webhook.
 *
 * # Available Methods
 * @method Methods\GetMe getMe() A simple method for testing your bot's auth token. Returns basic information about the
 *         bot in form of a User object.
 * @method Methods\SendMessage sendMessage(array $params = []) Send text messages.
 * @method Methods\ForwardMessage forwardMessage(array $params = []) Forward messages of any kind.
 * @method Methods\SendPhoto sendPhoto(array $params = []) Send a Photo.
 * @method Methods\SendAudio sendAudio(array $params = []) Send regular audio files.
 * @method Methods\SendDocument sendDocument(array $params = []) Send general files.
 * @method Methods\SendSticker sendSticker(array $params = []) Send .webp stickers.
 * @method Methods\SendVideo sendVideo(array $params = []) Send video files.
 * @method Methods\SendVoice sendVoice(array $params = []) Send voice audio files.
 * @method Methods\SendLocation sendLocation(array $params = []) Send point on the map.
 * @method Methods\SendVenue sendVenue(array $params = []) Send venue.
 * @method Methods\SendContact sendContact(array $params = []) Send contact.
 * @method Methods\SendChatAction sendChatAction(array $params = []) Broadcast a Chat Action.
 * @method Methods\GetUserProfilePhotos getUserProfilePhotos(array $params = []) Get a list of profile pictures for a
 *         user.
 * @method Methods\GetFile getFile(array $params = []) Get basic info about a file and prepare it for downloading.
 * @method Methods\KickChatMember kickChatMember(array $params = []) Kick a user from a group or a supergroup.
 * @method Methods\LeaveChat leaveChat(array $params = []) Use this method for your bot to leave a group, supergroup or
 *         channel.
 * @method Methods\UnbanChatMember unbanChatMember(array $params = []) Unban a previously kicked user in a supergroup.
 * @method Methods\GetChat getChat(array $params = []) Get up to date information about the chat.
 * @method Methods\GetChatAdministrators getChatAdministrators(array $params = []) Get a list of administrators in a
 *         chat.
 * @method Methods\GetChatMembersCount getChatMembersCount(array $params = []) Get the number of members in a chat.
 * @method Methods\GetChatMember getChatMember(array $params = []) Get information about a member of a chat.
 * @method Methods\AnswerCallbackQuery answerCallbackQuery(array $params = []) Send answers to callback queries sent
 *         from inline keyboards.
 *
 * # Updating Messages
 * @method Methods\EditMessageText editMessageText(array $params = []) Use this method to edit text messages sent by
 *         the bot or via the bot (for inline bots).
 * @method Methods\EditMessageCaption editMessageCaption(array $params = []) Use this method to edit captions of
 *         messages sent by the bot or via the bot (for inline bots).
 * @method Methods\EditMessageReplyMarkup editMessageReplyMarkup(array $params = []) Use this method to edit only the
 *         reply markup of messages sent by the bot or via the bot (for inline bots).
 *
 * # Inline Mode
 * @method Methods\AnswerInlineQuery answerInlineQuery(array $params = []) Use this method to send answers to an inline
 *         query.
 *
 */
class Api
{
    use EmitsEvents, Http, CommandsHandler, HasContainer;

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
    public static function manager($config)
    {
        return new BotsManager($config);
    }

    /**
     * Methods Factory
     *
     * @return MethodsFactory
     */
    public function methodsFactory()
    {
        return new MethodsFactory($this);
    }

    /**
     * Call an API Method using Methods Factory.
     *
     * @param       $method
     * @param array $params
     *
     * @return MethodsFactory
     * @throws TelegramSDKException
     */
    protected function callMethod($method, array $params = [])
    {
        return $this->methodsFactory()->create($method, $params);
    }

    /**
     * Returns a webhook update sent by Telegram.
     * Works only if you set a webhook.
     *
     * @see setWebhook
     *
     * @param bool $shouldEmitEvent
     *
     * @return Update
     */
    public function getWebhookUpdate($shouldEmitEvent = true)
    {
        $body = json_decode(file_get_contents('php://input'), true);

        $update = new Update($body);

        if ($shouldEmitEvent) {
            $this->emitEvent(new UpdateWasReceived($update, $this));
        }

        return $update;
    }

    /**
     * Alias for getWebhookUpdate
     *
     * @deprecated Call method getWebhookUpdate (note lack of letter s at end)
     *             To be removed in next major version.
     *
     * @param bool $shouldEmitEvent
     *
     * @return Update
     */
    public function getWebhookUpdates($shouldEmitEvent = true)
    {
        return $this->getWebhookUpdate($shouldEmitEvent);
    }

    /**
     * Removes the outgoing webhook (if any).
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    public function removeWebhook()
    {
        $url = '';

        return $this->post('setWebhook', compact('url'));
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
     * Determine if a given type is the message.
     *
     * @deprecated Call method isType directly on Message object
     *             To be removed in next major version.
     *
     * @param string                 $type
     * @param Update|Objects\Message $object
     *
     * @throws \ErrorException
     *
     */
    public function isMessageType($type, $object)
    {
        trigger_error('This method has been deprecated. Use isType() on the Message object instead.',
            E_USER_DEPRECATED);
    }

    /**
     * Detect Message Type Based on Update or Message Object.
     *
     * @deprecated Call method detectType directly on Message object
     *             To be removed in next major version.
     *
     * @param Update|Objects\Message $object
     *
     * @throws \ErrorException
     *
     * @return string|null
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

        $params = $arguments ? $arguments[0] : [];

        return $this->callMethod($method, $params);
    }
}
