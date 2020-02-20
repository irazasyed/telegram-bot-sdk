<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message as MessageObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Location.
 * @mixin Http
 */
trait Location
{
    /**
     * Send point on the map.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'latitude'             => '',
     *   'longitude'            => '',
     *   'live_period'          => '',
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @param array    $params               [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var float      $latitude             Required. Latitude of location
     * @var float      $longitude            Required. Longitude of location
     * @var int        $live_period          Optional. Period in seconds for which the location will be updated (see Live Locations, should be between 60 and 86400.
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
    public function sendLocation(array $params): MessageObject
    {
        $response = $this->post('sendLocation', $params);

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Edit live location messages sent by the bot or via the bot.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'message_id'           => '',
     *   'inline_message_id'    => '',
     *   'latitude'             => '',
     *   'longitude'            => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editmessagelivelocation
     *
     * @param array    $params            [
     *
     * @var int|string $chat_id           (Optional|Required). Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var int        $message_id        (Optional|Required). Required if inline_message_id is not specified. Identifier of the sent message
     * @var string     $inline_message_id (Optional|Required). Required if chat_id and message_id are not specified. Identifier of the inline message
     * @var float      $latitude          Required. Latitude of location
     * @var float      $longitude         Required. Longitude of location
     * @var string     $reply_markup      Optional. A JSON-serialized object for a new inline keyboard.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject|bool
     */
    public function editMessageLiveLocation(array $params)
    {
        $response = $this->post('editMessageLiveLocation', $params);

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Stop updating a live location message sent by the bot or via the bot.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'message_id'           => '',
     *   'inline_message_id'    => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @param array    $params            [
     *
     * @var int|string $chat_id           (Optional|Required). Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var int        $message_id        (Optional|Required). Required if inline_message_id is not specified. Identifier of the sent message
     * @var string     $inline_message_id (Optional|Required). Required if chat_id and message_id are not specified. Identifier of the inline message
     * @var string     $reply_markup      Optional. A JSON-serialized object for a new inline keyboard.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject|bool
     */
    public function stopMessageLiveLocation(array $params)
    {
        $response = $this->post('stopMessageLiveLocation', $params);

        return new MessageObject($response->getDecodedBody());
    }
}
