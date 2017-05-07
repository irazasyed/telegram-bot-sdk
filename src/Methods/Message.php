<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message as MessageObject;

/**
 * Class Message
 */
trait Message
{
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
     * @param array     $params                   [
     *
     * @type int|string $chat_id                  Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type string     $text                     Required. Text of the message to be sent
     * @type string     $parse_mode               Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
     * @type bool       $disable_web_page_preview Optional. Disables link previews for links in this message
     * @type bool       $disable_notification     Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int        $reply_to_message_id      Optional. If the message is a reply, ID of the original message
     * @type string     $reply_markup             Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendMessage(array $params): MessageObject
    {
        $response = $this->post('sendMessage', $params);

        return new MessageObject($response->getDecodedBody());
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
     * @param array     $params               [
     *
     * @type int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type int        $from_chat_id         Required. Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @type bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int        $message_id           Required. Message identifier in the chat specified in from_chat_id
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function forwardMessage(array $params): MessageObject
    {
        $response = $this->post('forwardMessage', $params);

        return new MessageObject($response->getDecodedBody());
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
     * @param array           $params               [
     *
     * @type int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type InputFile|string $photo                Required. Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload a new photo using multipart/form-data.
     * @type string           $caption              Optional. Photo caption (may also be used when resending photos by file_id), 0-200 characters
     * @type bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendPhoto(array $params): MessageObject
    {
        $response = $this->uploadFile('sendPhoto', $params, 'photo');

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Send regular audio files.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'audio'                => InputFile::create($resourceOrFile, $filename),
     *   'caption'              => '',
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
     * @param array           $params               [
     *
     * @type int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type InputFile|string $audio                Required. Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an audio file from the Internet, or upload a new one using multipart/form-data.
     * @type string           $caption              Optional. Audio caption, 0-200 characters
     * @type int              $duration             Optional. Duration of the audio in seconds
     * @type string           $performer            Optional. Performer
     * @type string           $title                Optional. Track name
     * @type bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendAudio(array $params): MessageObject
    {
        $response = $this->uploadFile('sendAudio', $params, 'audio');

        return new MessageObject($response->getDecodedBody());
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
     * @param array           $params               [
     *
     * @type int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type InputFile|string $document             Required. File to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data.
     * @type string           $caption              Optional. Document caption (may also be used when resending documents by file_id), 0-200 characters
     * @type bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendDocument(array $params): MessageObject
    {
        $response = $this->uploadFile('sendDocument', $params, 'document');

        return new MessageObject($response->getDecodedBody());
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
     * @param array           $params               [
     *
     * @type int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type InputFile|string $sticker              Required. Sticker to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a .webp file from the Internet, or upload a new one using multipart/form-data.
     * @type bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendSticker(array $params): MessageObject
    {
        if (is_file($params['sticker']) && (pathinfo($params['sticker'], PATHINFO_EXTENSION) !== 'webp')) {
            throw new TelegramSDKException('Invalid Sticker Provided. Supported Format: Webp');
        }

        $response = $this->uploadFile('sendSticker', $params, 'sticker');

        return new MessageObject($response->getDecodedBody());
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
     * @param array           $params               [
     *
     * @type int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type InputFile|string $video                Required. Video to send. Pass a file_id as String to send a video that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a video from the Internet, or upload a new video using multipart/form-data.
     * @type int              $duration             Optional. Duration of sent video in seconds
     * @type int              $width                Optional. Video width
     * @type int              $height               Optional. Video height
     * @type string           $caption              Optional    Video caption (may also be used when resending videos by file_id), 0-200 characters.
     * @type bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendVideo(array $params): MessageObject
    {
        $response = $this->uploadFile('sendVideo', $params, 'video');

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Send voice audio files.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'voice'                => InputFile::create($resourceOrFile, $filename),
     *   'caption'              => '',
     *   'duration'             => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendvoice
     *
     * @param array           $params               [
     *
     * @type int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type InputFile|string $voice                Required. Audio file to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data.
     * @type string           $caption              Optional. Voice message caption, 0-200 characters
     * @type int              $duration             Optional. Duration of the voice message in seconds
     * @type bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendVoice(array $params): MessageObject
    {
        $response = $this->uploadFile('sendVoice', $params, 'voice');

        return new MessageObject($response->getDecodedBody());
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
     * @param array     $params               [
     *
     * @type int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type float      $latitude             Required. Latitude of location
     * @type float      $longitude            Required. Longitude of location
     * @type bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string     $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendLocation(array $params): MessageObject
    {
        $response = $this->post('sendLocation', $params);

        return new MessageObject($response->getDecodedBody());
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
     * @param array     $params               [
     *
     * @type int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type float      $latitude             Required. Latitude of the venue
     * @type float      $longitude            Required. Longitude of the venue
     * @type string     $title                Required. Name of the venue
     * @type string     $address              Required. Address of the venue
     * @type string     $foursquare_id        Optional. Foursquare identifier of the venue
     * @type bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string     $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendVenue(array $params): MessageObject
    {
        $response = $this->post('sendVenue', $params);

        return new MessageObject($response->getDecodedBody());
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
     * @param array     $params               [
     *
     * @type int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type string     $phone_number         Required. Contact's phone number
     * @type string     $first_name           Required. Contact's first name
     * @type string     $last_name            Required. Contact's last name
     * @type bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @type int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @type string     $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendContact(array $params): MessageObject
    {
        $response = $this->post('sendContact', $params);

        return new MessageObject($response->getDecodedBody());
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
     * @param array     $params  [
     *
     * @type int|string $chat_id Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @type string     $action  Required. Type of action to broadcast. Choose one, depending on what the user is about to receive: typing for text messages, upload_photo for photos, record_video or upload_video for videos, record_audio or upload_audio for audio files, upload_document for general files, find_location for location data.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function sendChatAction(array $params): bool
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

        throw new TelegramSDKException('Invalid Action! Accepted value: ' . implode(', ', $validActions));
    }
}