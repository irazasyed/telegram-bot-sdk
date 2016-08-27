<?php

namespace Telegram\Bot;

use Telegram\Bot\Events\EmitsEvents;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\HttpClients\HttpClientInterface;
use Telegram\Bot\Objects\ChatMember;
use Telegram\Bot\Objects\UnknownObject;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Traits\Http;
use Telegram\Bot\Traits\CommandsHandler;
use Telegram\Bot\Traits\HasContainer;

/**
 * Class Api.
 *
 * @mixin Commands\CommandBus
 */
class Api
{
    use EmitsEvents, Http, CommandsHandler, HasContainer;

    /**
     * @var string Version number of the Telegram Bot PHP SDK.
     */
    const VERSION = '3.0.0';

    /**
     * @var string The name of the environment variable that contains the Telegram Bot API Access Token.
     */
    const BOT_TOKEN_ENV_NAME = 'TELEGRAM_BOT_TOKEN';

    /**
     * Instantiates a new Telegram super-class object.
     *
     *
     * @param string              $token                      The Telegram Bot API Access Token.
     * @param bool                $async                      (Optional) Indicates if the request to Telegram
     *                                                        will be asynchronous (non-blocking).
     * @param HttpClientInterface $httpClientHandler          (Optional) Custom HTTP Client Handler.
     *
     * @throws TelegramSDKException
     */
    public function __construct($token = null, $async = false, $httpClientHandler = null)
    {
        $this->accessToken = isset($token) ? $token : getenv(static::BOT_TOKEN_ENV_NAME);
        if (!$this->accessToken) {
            throw new TelegramSDKException('Required "token" not supplied in config and could not find fallback environment variable "'.static::BOT_TOKEN_ENV_NAME.'"');
        }

        if (isset($async)) {
            $this->setAsyncRequest($async);
        }

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
     * A simple method for testing your bot's auth token.
     * Returns basic information about the bot in form of a User object.
     *
     * @link https://core.telegram.org/bots/api#getme
     *
     * @throws TelegramSDKException
     *
     * @return Objects\User
     */
    public function getMe()
    {
        return $this->getWithReturnType('getMe', [], 'User');
    }

    /**
     * Send text messages.
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'disable_notification'     => '',
     *   'reply_to_message_id'      => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var string     $params ['text']
     * @var string     $params ['parse_mode']
     * @var bool       $params ['disable_web_page_preview']
     * @var bool       $params ['disable_notification']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendMessage(array $params)
    {
        return $this->postWithReturnType('sendMessage', $params, 'Message');
    }

    /**
     * Forward messages of any kind.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'from_chat_id'         => '',
     *   'disable_notification' => '',
     *   'message_id'           => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#forwardmessage
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var int        $params ['from_chat_id']
     * @var bool       $params ['disable_notification']
     * @var int        $params ['message_id']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function forwardMessage(array $params)
    {
        return $this->postWithReturnType('forwardMessage', $params, 'Message');
    }

    /**
     * Send Photos.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'photo'                => InputFile::create($resourceOrFile, $filename),
     *   'caption'              => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     *
     * @param array          $params
     *
     * @var int|string       $params ['chat_id']
     * @var InputFile|string $params ['photo']
     * @var string           $params ['caption']
     * @var bool             $params ['disable_notification']
     * @var int              $params ['reply_to_message_id']
     * @var string           $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendPhoto(array $params)
    {
        return $this->uploadWithReturnType('sendPhoto', $params, 'photo', 'Message');
    }

    /**
     * Send regular audio files.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'audio'                => InputFile::create($resourceOrFile, $filename),
     *   'duration'             => '',
     *   'performer'            => '',
     *   'title'                => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @param array          $params
     *
     * @var int|string       $params ['chat_id']
     * @var InputFile|string $params ['audio']
     * @var int              $params ['duration']
     * @var string           $params ['performer']
     * @var string           $params ['title']
     * @var bool             $params ['disable_notification']
     * @var int              $params ['reply_to_message_id']
     * @var string           $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendAudio(array $params)
    {
        return $this->uploadWithReturnType('sendAudio', $params, 'audio', 'Message');
    }

    /**
     * Send general files.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'document'             => InputFile::create($resourceOrFile, $filename),
     *   'caption'              => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#senddocument
     *
     * @param array          $params
     *
     * @var int|string       $params ['chat_id']
     * @var InputFile|string $params ['document']
     * @var string           $params ['caption']
     * @var bool             $params ['disable_notification']
     * @var int              $params ['reply_to_message_id']
     * @var string           $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendDocument(array $params)
    {
        return $this->uploadWithReturnType('sendDocument', $params, 'document', 'Message');
    }

    /**
     * Send .webp stickers.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'sticker'              => InputFile::create($resourceOrFile, $filename),
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @param array          $params
     *
     * @var int|string       $params ['chat_id']
     * @var InputFile|string $params ['sticker']
     * @var bool             $params ['disable_notification']
     * @var int              $params ['reply_to_message_id']
     * @var string           $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendSticker(array $params)
    {
        if (is_file($params['sticker']) && (pathinfo($params['sticker'], PATHINFO_EXTENSION) !== 'webp')) {
            throw new TelegramSDKException('Invalid Sticker Provided. Supported Format: Webp');
        }

        return $this->uploadWithReturnType('sendSticker', $params, 'sticker', 'Message');
    }

    /**
     * Send Video File, Telegram clients support mp4 videos (other formats may be sent as Document).
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'video'                => InputFile::create($resourceOrFile, $filename),
     *   'duration'             => '',
     *   'width'                => '',
     *   'height'               => '',
     *   'caption'              => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @see  sendDocument
     * @link https://core.telegram.org/bots/api#sendvideo
     *
     * @param array          $params
     *
     * @var int|string       $params ['chat_id']
     * @var InputFile|string $params ['video']
     * @var int              $params ['duration']
     * @var int              $params ['width']
     * @var int              $params ['height']
     * @var string           $params ['caption']
     * @var bool             $params ['disable_notification']
     * @var int              $params ['reply_to_message_id']
     * @var string           $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendVideo(array $params)
    {
        return $this->uploadWithReturnType('sendVideo', $params, 'video', 'Message');
    }

    /**
     * Send voice audio files.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'voice'                => InputFile::create($resourceOrFile, $filename),
     *   'duration'             => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @param array          $params
     *
     * @var int|string       $params ['chat_id']
     * @var InputFile|string $params ['voice']
     * @var int              $params ['duration']
     * @var bool             $params ['disable_notification']
     * @var int              $params ['reply_to_message_id']
     * @var string           $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendVoice(array $params)
    {
        return $this->uploadWithReturnType('sendVoice', $params, 'voice', 'Message');
    }

    /**
     * Send point on the map.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'latitude'             => '',
     *   'longitude'            => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var float      $params ['latitude']
     * @var float      $params ['longitude']
     * @var bool       $params ['disable_notification']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendLocation(array $params)
    {
        return $this->postWithReturnType('sendLocation', $params, 'Message');
    }

    /**
     * Send information about a venue.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'latitude'             => '',
     *   'longitude'            => '',
     *   'title'                => '',
     *   'address'              => '',
     *   'foursquare_id'        => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendvenue
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var float      $params ['latitude']
     * @var float      $params ['longitude']
     * @var string     $params ['title']
     * @var string     $params ['address']
     * @var string     $params ['foursquare_id']
     * @var bool       $params ['disable_notification']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendVenue(array $params)
    {
        return $this->postWithReturnType('sendVenue', $params, 'Message');
    }

    /**
     * Send phone contacts.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'phone_number'         => '',
     *   'first_name'           => '',
     *   'last_name'            => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendcontact
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var string     $params ['phone_number']
     * @var string     $params ['first_name']
     * @var string     $params ['last_name']
     * @var bool       $params ['disable_notification']
     * @var int        $params ['reply_to_message_id']
     * @var string     $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message
     */
    public function sendContact(array $params)
    {
        return $this->postWithReturnType('sendContact', $params, 'Message');
    }

    /**
     * Broadcast a Chat Action.
     *
     * <code>
     * $params = [
     *   'chat_id' => '',
     *   'action'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendchataction
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var string     $params ['action']
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function sendChatAction(array $params)
    {
        $validActions = [
            'typing',
            'upload_photo',
            'record_video',
            'upload_video',
            'record_audio',
            'upload_audio',
            'upload_document',
            'find_location',
        ];

        if (isset($params['action']) && in_array($params['action'], $validActions)) {
            $this->post('sendChatAction', $params);

            return true;
        }

        throw new TelegramSDKException('Invalid Action! Accepted value: '.implode(', ', $validActions));
    }

    /**
     * Returns a list of profile pictures for a user.
     *
     * <code>
     * $params = [
     *   'user_id' => '',
     *   'offset'  => '',
     *   'limit'   => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @param array $params
     *
     * @var int     $params ['user_id']
     * @var int     $params ['offset']
     * @var int     $params ['limit']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\UserProfilePhotos
     */
    public function getUserProfilePhotos(array $params)
    {
        return $this->getWithReturnType('getUserProfilePhotos', $params, 'UserProfilePhotos');
    }

    /**
     * Returns basic info about a file and prepare it for downloading.
     *
     * <code>
     * $params = [
     *   'file_id' => '',
     * ];
     * </code>
     *
     * The file can then be downloaded via the link
     * https://api.telegram.org/file/bot<token>/<file_path>,
     * where <file_path> is taken from the response.
     *
     * @link https://core.telegram.org/bots/api#getFile
     *
     * @param array $params
     *
     * @var string  $params ['file_id']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\File
     */
    public function getFile(array $params)
    {
        return $this->getWithReturnType('getFile', $params, 'File');
    }

    /**
     * Kick a user from a group or a supergroup.
     *
     * In the case of supergroups, the user will not be able to return to the group on their own using
     * invite links etc., unless unbanned first.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'user_id'              => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#kickchatmember
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var int        $params ['user_id']
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function kickChatMember(array $params)
    {
        $this->get('kickChatMember', $params);

        return true;
    }

    /**
     * Unban a previously kicked user in a supergroup.
     *
     * The user will not return to the group automatically, but will be able to join via link, etc.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'user_id'              => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#unbanchatmember
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var int        $params ['user_id']
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function unbanChatMember(array $params)
    {
        $this->get('unbanChatMember', $params);

        return true;
    }

    /**
     * Get up to date information about the chat (current name of the user for one-on-one conversations,
     * current username of a user, group or channel,
     *
     * <code>
     * $params = [
     *   'chat_id'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getchat
     *
     * @param array    $params
     *
     * @var string|int $params ['chat_id'] Unique identifier for the target chat or username of the target supergroup
     *      or channel (in the format @channelusername)
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Chat
     */
    public function getChat(array $params)
    {
        return $this->getWithReturnType('getChat', $params, 'Chat');
    }

    /**
     * Get a list of administrators in a chat.
     *
     * <code>
     * $params = [
     *   'chat_id'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getchatadministrators
     *
     * @param array    $params
     *
     * @var string|int $params ['chat_id'] Unique identifier for the target chat or username of the target supergroup
     *      or channel (in the format @channelusername);
     *
     * @throws TelegramSDKException
     *
     * @return ChatMember[]
     */
    public function getChatAdministrators(array $params)
    {
        $response = $this->get('getChatAdministrators', $params);

        return collect($response->getResult())
            ->map(function ($admin) {
                return new ChatMember($admin);
            })
            ->all();
    }

    /**
     * Get the number of members in a chat
     *
     * <code>
     * $params = [
     *   'chat_id'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getchatmemberscount
     *
     * @param array    $params
     *
     * @var string|int $params ['chat_id'] Unique identifier for the target chat or username of the target supergroup
     *      or channel (in the format @channelusername)
     *
     * @throws TelegramSDKException
     *
     * @return int
     */
    public function getChatMembersCount(array $params)
    {
        $response = $this->get('getChatMembersCount', $params);

        return $response->getResult();
    }

    /**
     * Get information about a member of a chat.
     *
     * <code>
     * $params = [
     *   'chat_id'  => '',
     *   'user_id'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getchatmember
     *
     * @param array    $params
     *
     * @var string|int $params ['chat_id'] Unique identifier for the target chat or username of the target supergroup
     *      or channel (in the format @channelusername)
     * @var int        $params ['user_id'] Unique identifier of the target user.
     *
     * @throws TelegramSDKException
     *
     * @return ChatMember
     */
    public function getChatMember(array $params)
    {
        return $this->getWithReturnType('getChatMember', $params, 'ChatMember');
    }

    /**
     * Send answers to callback queries sent from inline keyboards.
     *
     * he answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
     *
     * <code>
     * $params = [
     *   'callback_query_id'  => '',
     *   'text'               => '',
     *   'show_alert'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#answerCallbackQuery
     *
     * @param array $params
     *
     * @var string  $params ['callback_query_id']
     * @var string  $params ['text']
     * @var bool    $params ['show_alert']
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function answerCallbackQuery(array $params)
    {
        $this->post('answerCallbackQuery', $params);

        return true;
    }


    /**
     * Edit text messages sent by the bot or via the bot (for inline bots).
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editMessageText
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var int        $params ['message_id']
     * @var string     $params ['inline_message_id']
     * @var string     $params ['text']
     * @var string     $params ['parse_mode']
     * @var bool       $params ['disable_web_page_preview']
     * @var string     $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message|bool
     */
    public function editMessageText(array $params)
    {
        return $this->postWithReturnType('editMessageText', $params, 'Message');
    }

    /**
     * Edit captions of messages sent by the bot or via the bot (for inline bots).
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'caption'                  => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editMessageCaption
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var int        $params ['message_id']
     * @var string     $params ['inline_message_id']
     * @var string     $params ['caption']
     * @var string     $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message|bool
     */
    public function editMessageCaption(array $params)
    {
        return $this->postWithReturnType('editMessageCaption', $params, 'Message');
    }

    /**
     * Edit only the reply markup of messages sent by the bot or via the bot (for inline bots).
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editMessageReplyMarkup
     *
     * @param array    $params
     *
     * @var int|string $params ['chat_id']
     * @var int        $params ['message_id']
     * @var string     $params ['inline_message_id']
     * @var string     $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Objects\Message|bool
     */
    public function editMessageReplyMarkup(array $params)
    {
        return $this->postWithReturnType('editMessageReplyMarkup', $params, 'Message');
    }

    /**
     * Use this method to send answers to an inline query.
     *
     * <code>
     * $params = [
     *   'inline_query_id'      => '',
     *   'results'              => [],
     *   'cache_time'           => 0,
     *   'is_personal'          => false,
     *   'next_offset'          => '',
     *   'switch_pm_text'       => '',
     *   'switch_pm_parameter'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#answerinlinequery
     *
     * @param array     $params
     *
     * @var string      $params ['inline_query_id']
     * @var array       $params ['results']
     * @var int|null    $params ['cache_time']
     * @var bool|null   $params ['is_personal']
     * @var string|null $params ['next_offset']
     * @var string|null $params ['switch_pm_text']
     * @var string|null $params ['switch_pm_parameter']
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function answerInlineQuery(array $params = [])
    {
        if (is_array($params['results'])) {
            $params['results'] = json_encode($params['results']);
        }

        $this->post('answerInlineQuery', $params);

        return true;
    }

    /**
     * Set a Webhook to receive incoming updates via an outgoing webhook.
     *
     * <code>
     * $params = [
     *   'url'         => '',
     *   'certificate' => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @param array $params
     *
     * @var string  $params ['url']         HTTPS url to send updates to.
     * @var string  $params ['certificate'] Upload your public key certificate so that the root certificate in
     *                                      use can be checked.
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    public function setWebhook(array $params)
    {
        if (filter_var($params['url'], FILTER_VALIDATE_URL) === false) {
            throw new TelegramSDKException('Invalid URL Provided');
        }

        if (parse_url($params['url'], PHP_URL_SCHEME) !== 'https') {
            throw new TelegramSDKException('Invalid URL, should be a HTTPS url.');
        }

        return $this->uploadFile('setWebhook', $params, 'certificate');
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
     * Use this method to receive incoming updates using long polling.
     *
     * <code>
     * $params = [
     *   'offset'  => '',
     *   'limit'   => '',
     *   'timeout' => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @param array  $params
     * @param bool   $shouldEmitEvents
     *
     * @var int|null $params ['offset']
     * @var int|null $params ['limit']
     * @var int|null $params ['timeout']
     *
     * @throws TelegramSDKException
     *
     * @return Update[]
     */
    public function getUpdates(array $params = [], $shouldEmitEvents = true)
    {
        $response = $this->post('getUpdates', $params);

        return collect($response->getResult())
            ->map(function ($data) use ($shouldEmitEvents) {

                $update = new Update($data);

                if ($shouldEmitEvents) {
                    $this->emitEvent(new UpdateWasReceived($update, $this));
                }

                return $update;
            })
            ->all();
    }

    /**
     * An alias for getUpdates that helps readability.
     *
     * @param $params
     *
     * @return Objects\Update[]
     */
    protected function markUpdateAsRead($params)
    {
        return $this->getUpdates($params, false);
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
     * @param string         $type
     * @param Update|Message $object
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
     * @param Update|Message $object
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
     * Magic method to process any "get" requests.
     *
     * @param $method
     * @param $arguments
     *
     * @throws TelegramSDKException
     *
     * @return bool|TelegramResponse|UnknownObject
     */
    public function __call($method, $arguments)
    {
        if (preg_match('/^\w+Commands?/', $method, $matches)) {
            return call_user_func_array([$this->getCommandBus(), $matches[0]], $arguments);
        }

        if (starts_with($method, 'get')) {
            /* @noinspection PhpUndefinedFunctionInspection */
            $class_name = studly_case(substr($method, 3));
            $class = 'Telegram\Bot\Objects\\'.$class_name;
            $response = $this->post($method, $arguments[0] ?: []);

            if (class_exists($class)) {
                return new $class($response->getDecodedBody());
            }

            return $response;
        }
        $response = $this->post($method, $arguments[0]);

        return new UnknownObject($response->getDecodedBody());
    }
}
