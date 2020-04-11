<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Message as MessageObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Message.
 * @mixin Http
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
     * @param array    $params                   [
     *
     * @var int|string $chat_id                  Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var string     $text                     Required. Text of the message to be sent
     * @var string     $parse_mode               Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
     * @var bool       $disable_web_page_preview Optional. Disables link previews for links in this message
     * @var bool       $disable_notification     Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int        $reply_to_message_id      Optional. If the message is a reply, ID of the original message
     * @var string     $reply_markup             Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
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
     * @param array    $params               [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var int        $from_chat_id         Required. Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
     * @var bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int        $message_id           Required. Message identifier in the chat specified in from_chat_id
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
     * Send Photo.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'photo'                => InputFile::create($resourceOrFile, $filename),
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendphoto
     *
     * @param array          $params               [
     *
     * @var int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile|string $photo                Required. Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload a new photo using multipart/form-data.
     * @var string           $caption              Optional. Photo caption (may also be used when resending photos by file_id), 0-200 characters
     * @var string           $parse_mode           Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
     * @var bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
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
     *   'parse_mode'           => '',
     *   'duration'             => '',
     *   'performer'            => '',
     *   'title'                => '',
     *   'thumb'                => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendaudio
     *
     * @param array          $params               [
     *
     * @var int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile|string $audio                Required. Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an audio file from the Internet, or upload a new one using multipart/form-data.
     * @var string           $caption              Optional. Audio caption, 0-200 characters
     * @var string           $parse_mode           Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
     * @var int              $duration             Optional. Duration of the audio in seconds
     * @var string           $performer            Optional. Performer
     * @var string           $title                Optional. Track name
     * @var InputFile|string $thumb                Optional. Thumbnail of the file sent. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail‘s width and height should not exceed 90. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>
     * @var bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
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
     *   'thumb'                => '',
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#senddocument
     *
     * @param array          $params               [
     *
     * @var int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile|string $document             Required. File to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data.
     * @var string           $caption              Optional. Document caption (may also be used when resending documents by file_id), 0-200 characters
     * @var string           $parse_mode           Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
     * @var bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
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
     * Send Video File, Telegram clients support mp4 videos (other formats may be sent as Document).
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'video'                => InputFile::create($resourceOrFile, $filename),
     *   'duration'             => '',
     *   'width'                => '',
     *   'height'               => '',
     *   'thumb'                => '',
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'supports_streaming'   => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @see  sendDocument
     * @link https://core.telegram.org/bots/api#sendvideo
     *
     * @param array          $params               [
     *
     * @var int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile|string $video                Required. Video to send. Pass a file_id as String to send a video that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a video from the Internet, or upload a new video using multipart/form-data.
     * @var int              $duration             Optional. Duration of sent video in seconds
     * @var int              $width                Optional. Video width
     * @var int              $height               Optional. Video height
     * @var string           $caption              Optional  Video caption (may also be used when resending videos by file_id), 0-200 characters.
     * @var string           $parse_mode           Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
     * @var bool             $supports_streaming   Optional. Pass True, if the uploaded video is suitable for streaming
     * @var bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
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
     * Send send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'animation'            => InputFile::create($resourceOrFile, $filename),
     *   'duration'             => '',
     *   'width'                => '',
     *   'height'               => '',
     *   'thumb'                => '',
     *   'caption'              => '',
     *   'parse_mode'           => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendanimation
     *
     * @param array          $params               [
     *
     * @var int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile|string $animation            Required. Animation to send. Pass a file_id as String to send an animation that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an animation from the Internet, or upload a new animation using multipart/form-data.
     * @var int              $duration             Optional. Duration of sent animation in seconds
     * @var int              $width                Optional. Animation width
     * @var int              $height               Optional. Animation height
     * @var InputFile|string $thumb                Optional. Thumbnail of the file sent. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail‘s width and height should not exceed 90. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>
     * @var string           $caption              Optional. Document caption (may also be used when resending documents by file_id), 0-200 characters
     * @var string           $parse_mode           Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
     * @var bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendAnimation(array $params): MessageObject
    {
        $response = $this->uploadFile('sendAnimation', $params, 'animation');

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
     *   'parse_mode'           => '',
     *   'duration'             => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendvoice
     *
     * @param array          $params               [
     *
     * @var int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile|string $voice                Required. Audio file to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data.
     * @var string           $caption              Optional. Voice message caption, 0-200 characters
     * @var string           $parse_mode           Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
     * @var int              $duration             Optional. Duration of the voice message in seconds
     * @var bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
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
     * Send rounded square mp4 videos of up to 1 minute long. Use this method to send video messages.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'video_note'           => InputFile::create($resourceOrFile, $filename),
     *   'duration'             => '',
     *   'length'               => '',
     *   'thumb'                => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendvideonote
     *
     * @param array          $params               [
     *
     * @var int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile|string $video_note           Required. Video note to send. Pass a file_id as String to send a video note that exists on the Telegram servers (recommended) or upload a new video using multipart/form-data.
     * @var int              $duration             Optional. Duration of sent video in seconds
     * @var int              $length               Optional. Video width and height
     * @var InputFile|string $thumb                Optional. Thumbnail of the file sent. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail‘s width and height should not exceed 90. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>
     * @var bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendVideoNote(array $params): MessageObject
    {
        $response = $this->uploadFile('sendVideoNote', $params, 'video_note');

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Send a group of photos or videos as an album.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'media'                => [],
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendmediagroup
     *
     * @param array    $params               [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var array      $media                Required. A JSON-serialized array describing photos and videos to be sent, must include 2–10 items
     * @var int        $duration             Optional. Duration of sent video in seconds
     * @var bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * //TODO Check this return type.
     * @return MessageObject
     */
    public function sendMediaGroup(array $params)
    {
        $response = $this->uploadFile('sendMediaGroup', $params, 'media');

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
     *   'foursquare_type'      => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendvenue
     *
     * @param array    $params               [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var float      $latitude             Required. Latitude of the venue
     * @var float      $longitude            Required. Longitude of the venue
     * @var string     $title                Required. Name of the venue
     * @var string     $address              Required. Address of the venue
     * @var string     $foursquare_id        Optional. Foursquare identifier of the venue
     * @var string     $foursquare_type      Optional. Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
     * @var bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string     $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
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
     *   'vcard'                => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendcontact
     *
     * @param array    $params               [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var string     $phone_number         Required. Contact's phone number
     * @var string     $first_name           Required. Contact's first name
     * @var string     $last_name            Required. Contact's last name
     * @var string     $vcard                Optional. Additional data about the contact in the form of a vCard, 0-2048 bytes
     * @var bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string     $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
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
     * Send a poll.
     *
     * Use this method to send a native poll. A native poll can't be sent to a private chat.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'question'             => '',
     *   'options'              => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendpoll
     *
     * @param array    $params               [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername). A native poll can't be sent to a private chat.
     * @var string     $question             Required. Poll question, 1-255 characters
     * @var array      $options              Required. List of answer options, 2-10 strings 1-100 characters each
     * @var bool       $disable_notification Optional. Sends the message silently. Users will receive a notification with no sound.
     * @var int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string     $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendPoll(array $params): MessageObject
    {
        $params['options'] = json_encode($params['options']);
        $response = $this->post('sendPoll', $params);

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Send a dice.
     *
     * Use this method to send a dice, which will have a random value from 1 to 6
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#senddice
     *
     * @param array    $params               [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername). A native poll can't be sent to a private chat.
     * @var bool       $disable_notification Optional. Sends the message silently. Users will receive a notification with no sound.
     * @var int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string     $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendDice(array $params): MessageObject
    {
        $response = $this->post('sendDice', $params);

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
     * @param array    $params  [
     *
     * @var int|string $chat_id Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var string     $action  Required. Type of action to broadcast. Choose one, depending on what the user is about to receive: typing for text messages, upload_photo for photos, record_video or upload_video for videos, record_audio or upload_audio for audio files, upload_document for general files, find_location for location data.
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
            'record_video_note',
            'upload_video_note',
        ];

        if (isset($params['action']) && in_array($params['action'], $validActions)) {
            $this->post('sendChatAction', $params);

            return true;
        }

        throw new TelegramSDKException('Invalid Action! Accepted value: '.implode(', ', $validActions));
    }
}
