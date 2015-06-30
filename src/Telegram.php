<?php

namespace Irazasyed\Telegram;

use Irazasyed\Telegram\Objects\User;
use Irazasyed\Telegram\Objects\Update;
use Irazasyed\Telegram\Objects\Message;
use Irazasyed\Telegram\Objects\UserProfilePhotos;

use Irazasyed\Telegram\TelegramClient;
use Irazasyed\Telegram\TelegramRequest;
use Irazasyed\Telegram\TelegramResponse;
use Irazasyed\Telegram\FileUpload\InputFile;
use Irazasyed\Telegram\HttpClients\GuzzleHttpClient;
use Irazasyed\Telegram\Exceptions\TelegramSDKException;

/**
 * Class Telegram
 *
 * @package Telegram
 */
class Telegram
{
    /**
     * @const string Version number of the Telegram Bot PHP SDK.
     */
    const VERSION = '0.1.0';

    /**
     * @const string The name of the environment variable that contains the Telegram Bot API Access Token.
     */
    const BOT_TOKEN_ENV_NAME = 'TELEGRAM_BOT_TOKEN';

    /**
     * @var TelegramClient The Telegram client service.
     */
    protected $client;

    /**
     * @var string Telegram Bot API Access Token.
     */
    protected $accessToken = null;

    /**
     * @var TelegramResponse|null Stores the last request made to Telegram Bot API.
     */
    protected $lastResponse;

    /**
     * Indicates if the request to Telegram will be asynchronous (non-blocking).
     *
     * @var boolean
     */
    protected $isAsyncRequest = false;

    /**
     * Instantiates a new Telegram super-class object.
     *
     *
     * @param string                             $token               The Telegram Bot API Access Token.
     * @param bool                               $async               (Optional) Indicates if the request to Telegram
     *                                                                will be asynchronous (non-blocking).
     * @param string|TelegramHttpClientInterface $http_client_handler (Optional) Custom HTTP Client Handler.
     *
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function __construct($token, $async = false, $http_client_handler = null)
    {
        $this->accessToken = isset($token) ? $token : getenv(static::BOT_TOKEN_ENV_NAME);
        if (!$this->accessToken) {
            throw new TelegramSDKException('Required "token" key not supplied in config and could not find fallback environment variable "'.static::BOT_TOKEN_ENV_NAME.'"');
        }

        $httpClientHandler = null;
        if (isset($http_client_handler)) {
            if ($http_client_handler instanceof TelegramHttpClientInterface) {
                $httpClientHandler = $http_client_handler;
            } elseif ($http_client_handler === 'guzzle') {
                $httpClientHandler = new GuzzleHttpClient();
            } else {
                throw new \InvalidArgumentException('The HTTP Client Handler must be set to "guzzle", or be an instance of Irazasyed\Telegram\HttpClients\TelegramHttpClientInterface');
            }
        }

        if (isset($async)) {
            $this->setAsyncRequest($async);
        }

        $this->client = new TelegramClient($httpClientHandler);
    }

    /**
     * Returns the TelegramClient service.
     *
     * @return TelegramClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Returns Telegram Bot API Access Token.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Returns the last response returned from API request.
     *
     * @return TelegramResponse
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Sets the bot access token to use with API requests.
     *
     * @param string $accessToken The bot access token to save.
     *
     * @return Telegram
     *
     * @throws \InvalidArgumentException
     */
    public function setAccessToken($accessToken)
    {
        if (is_string($accessToken)) {
            $this->accessToken = $accessToken;

            return $this;
        }

        throw new \InvalidArgumentException('The Telegram bot access token must be of type "string"');
    }

    /**
     * Make this request asynchronous (non-blocking).
     *
     * @param bool $isAsyncRequest
     *
     * @return TelegramRequest
     */
    public function setAsyncRequest($isAsyncRequest)
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     *
     * @return bool
     */
    public function isAsyncRequest()
    {
        return $this->isAsyncRequest;
    }

    /**
     * A simple method for testing your bot's auth token.
     * Returns basic information about the bot in form of a User object.
     *
     * @link https://core.telegram.org/bots/api#getme
     *
     * @return \Irazasyed\Telegram\Objects\User
     */
    public function getMe()
    {
        $response = $this->get('getMe');

        return new User($response->getDecodedBody());
    }

    /**
     * Send text messages.
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @param integer                                          $chat_id
     * @param string                                           $text
     * @param bool                                             $disable_web_page_preview
     * @param integer                                          $reply_to_message_id
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply $reply_markup
     *
     *
     * @return \Irazasyed\Telegram\Objects\Message
     */
    public function sendMessage(
        $chat_id,
        $text,
        $disable_web_page_preview = false,
        $reply_to_message_id = null,
        $reply_markup = null
    ) {
        $params = compact('chat_id', 'text', 'disable_web_page_preview', 'reply_to_message_id', 'reply_markup');
        $response = $this->get('sendMessage', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Forward messages of any kind.
     *
     * @link https://core.telegram.org/bots/api#forwardmessage
     *
     * @param integer $chat_id
     * @param integer $from_chat_id
     * @param integer $message_id
     *
     * @return \Irazasyed\Telegram\Objects\Message
     */
    public function forwardMessage($chat_id, $from_chat_id, $message_id)
    {
        $params = compact('chat_id', 'from_chat_id', 'message_id');
        $response = $this->get('forwardMessage', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Send Photos.
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     *
     * @param integer                                          $chat_id
     * @param string                                           $photo
     * @param string                                           $caption
     * @param integer                                          $reply_to_message_id
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply $reply_markup
     *
     * @return \Irazasyed\Telegram\Objects\Message
     */
    public function sendPhoto($chat_id, $photo, $caption = null, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'photo', 'caption', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendPhoto', $params);
    }

    /**
     * Send audio files.
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @param integer                                          $chat_id
     * @param string                                           $audio
     * @param integer                                          $reply_to_message_id
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply $reply_markup
     *
     * @return \Irazasyed\Telegram\Objects\Message
     */
    public function sendAudio($chat_id, $audio, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'audio', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendAudio', $params);
    }

    /**
     * Send general files.
     *
     * @link https://core.telegram.org/bots/api#senddocument
     *
     * @param integer                                          $chat_id
     * @param string                                           $document
     * @param integer                                          $reply_to_message_id
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply $reply_markup
     *
     * @return \Irazasyed\Telegram\Objects\Message
     */
    public function sendDocument($chat_id, $document, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'document', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendDocument', $params);
    }

    /**
     * Send .webp stickers.
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @param integer                                          $chat_id
     * @param string                                           $sticker
     * @param integer                                          $reply_to_message_id
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply $reply_markup
     *
     * @return \Irazasyed\Telegram\Objects\Message
     *
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function sendSticker($chat_id, $sticker, $reply_to_message_id = null, $reply_markup = null)
    {
        if (is_file($sticker) && (pathinfo($sticker, PATHINFO_EXTENSION) !== 'webp')) {
            throw new TelegramSDKException('Invalid Sticker Provided. Supported Format: Webp');
        }

        $params = compact('chat_id', 'sticker', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendSticker', $params);
    }

    /**
     * Send Video File, Telegram clients support mp4 videos (other formats may be sent as Document).
     *
     * @see  sendDocument
     * @link https://core.telegram.org/bots/api#sendvideo
     *
     * @param integer                                          $chat_id
     * @param string                                           $video
     * @param integer                                          $reply_to_message_id
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply $reply_markup
     *
     * @return \Irazasyed\Telegram\Objects\Message
     */
    public function sendVideo($chat_id, $video, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'video', 'reply_to_message_id', 'reply_markup');

        return $this->uploadFile('sendVideo', $params);
    }

    /**
     * Send point on the map.
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @param integer                                          $chat_id
     * @param float                                            $latitude
     * @param float                                            $longitude
     * @param integer                                          $reply_to_message_id
     * @param ReplyKeyboardMarkup|ReplyKeyboardHide|ForceReply $reply_markup
     *
     * @return \Irazasyed\Telegram\Objects\Message
     */
    public function sendLocation($chat_id, $latitude, $longitude, $reply_to_message_id = null, $reply_markup = null)
    {
        $params = compact('chat_id', 'latitude', 'longitude', 'reply_to_message_id', 'reply_markup');
        $response = $this->get('sendLocation', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Broadcast a Chat Action.
     *
     * @link https://core.telegram.org/bots/api#sendchataction
     *
     * @param integer $chat_id
     * @param string  $action
     *
     * @return \Irazasyed\Telegram\TelegramResponse
     *
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function sendChatAction($chat_id, $action)
    {
        $validActions = [
            'typing',
            'upload_photo',
            'record_video',
            'upload_video',
            'record_audio',
            'upload_audio',
            'upload_document',
            'find_location'
        ];

        if (isset($action) && in_array($action, $validActions)) {
            return $this->get('sendChatAction', compact('chat_id', 'action'));
        }

        throw new TelegramSDKException('Invalid Action! Accepted value: '.implode(', ', $validActions));
    }


    /**
     * Returns a list of profile pictures for a user.
     *
     * @link https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @param integer $user_id
     * @param integer $offset
     * @param integer $limit
     *
     * @return \Irazasyed\Telegram\Objects\UserProfilePhotos
     */
    public function getUserProfilePhotos($user_id, $offset = null, $limit = null)
    {
        $response = $this->get('getUserProfilePhotos', compact('user_id', 'offset', 'limit'));

        return new UserProfilePhotos($response->getDecodedBody());
    }

    /**
     * Set a Webhook to receive incoming updates via an outgoing webhook.
     *
     * @param string $url HTTPS url to send updates to.
     *
     * @return \Irazasyed\Telegram\TelegramResponse
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function setWebhook($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new TelegramSDKException('Invalid URL Provided');
        }

        if (parse_url($url, PHP_URL_SCHEME) !== 'https') {
            throw new TelegramSDKException('Invalid URL, should be a HTTPS url.');
        }

        return $this->get('setWebhook', compact('url'));
    }

    /**
     * Removes the outgoing webhook (if any).
     *
     * @return \Irazasyed\Telegram\TelegramResponse
     */
    public function removeWebhook()
    {
        $url = '';

        return $this->get('setWebhook', compact('url'));
    }

    /**
     * Sends a GET request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return TelegramResponse
     *
     * @throws TelegramSDKException
     */
    public function get($endpoint, $params = [])
    {
        return $this->sendRequest(
            'GET',
            $endpoint,
            $params
        );
    }

    /**
     * Sends a POST request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return TelegramResponse
     *
     * @throws TelegramSDKException
     */
    public function post($endpoint, array $params = [])
    {
        return $this->sendRequest(
            'POST',
            $endpoint,
            $params
        );
    }

    /**
     * Sends a multipart/form-data request to Telegram Bot API and returns the result.
     * Used primarily for file uploads.
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return \Irazasyed\Telegram\Objects\Message
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function uploadFile($endpoint, array $params = [])
    {
        $i = 0;
        $multipart_params = [];
        foreach ($params as $name => $contents) {
            if (is_file($contents)) {
                $file = new InputFile($contents);
                $contents = $file->open();
            }
            $multipart_params[$i]['name'] = $name;
            $multipart_params[$i]['contents'] = $contents;
            $i++;
        }

        $response = $this->post($endpoint, [
            'multipart' => $multipart_params
        ]);

        return new Message($response->getDecodedBody());
    }

    /**
     * Sends a request to Telegram Bot API and returns the result.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     *
     * @return TelegramResponse
     *
     * @throws TelegramSDKException
     */
    public function sendRequest(
        $method,
        $endpoint,
        array $params = []
    ) {
        $request = $this->request($method, $endpoint, $params);

        return $this->lastResponse = $this->client->sendRequest($request);
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
    public function request(
        $method,
        $endpoint,
        array $params = []
    ) {
        return new TelegramRequest(
            $this->getAccessToken(),
            $method,
            $endpoint,
            $params,
            $this->isAsyncRequest()
        );
    }

    /**
     * Magic method to process any "get" requests.
     *
     * @param $method
     * @param $arguments
     *
     * @return bool|\Irazasyed\Telegram\TelegramResponse
     */
    public function __call($method, $arguments)
    {
        $action = substr($method, 0, 3);
        if ($action === 'get') {
            $class_name = studly_case(substr($method, 3));
            $class = 'Irazasyed\Telegram\Objects\\'.$class_name;
            $response = $this->get($method, $arguments[0] ?: []);

            if (class_exists($class)) {
                return new $class($response->getDecodedBody());
            }

            return $response;
        }

        return false;
    }
}