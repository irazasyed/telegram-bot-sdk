<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message as MessageObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Location.
 *
 * @mixin Http
 */
trait Location
{
    /**
     * Send point on the map.
     *
     * <code>
     * $params = [
     *       'chat_id'                     => '',  // int|string - Required. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'latitude'                    => '',  // float      - Required. Latitude of location
     *       'longitude'                   => '',  // float      - Required. Longitude of location
     *       'horizontal_accuracy          => '',  // float      - (Optional). The radius of uncertainty for the location, measured in meters; 0-1500
     *       'live_period'                 => '',  // int        - (Optional). Period in seconds for which the location will be updated (see Live Locations, should be between 60 and 86400.
     *       'heading'                     => '',  // int        - (Optional). For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     *       'proximity_alert_radius'      => '',  // int        - (Optional). For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     *       'disable_notification'        => '',  // bool       - (Optional). Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     *       'protect_content'             => '',  // bool       - (Optional). Protects the contents of the sent message from forwarding and saving
     *       'reply_to_message_id'         => '',  // int        - (Optional). If the message is a reply, ID of the original message
     *       'allow_sending_without_reply' => '',  // bool       - (Optional). Pass True, if the message should be sent even if the specified replied-to message is not found
     *       'reply_markup'                => '',  // string     - (Optional). Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendlocation
     *
     * @throws TelegramSDKException
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
     *       'chat_id'                => '',  // int|string - (Optional|Required). Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'message_id'             => '',  // int        - (Optional|Required). Required if inline_message_id is not specified. Identifier of the sent message
     *       'inline_message_id'      => '',  // string     - (Optional|Required). Required if chat_id and message_id are not specified. Identifier of the inline message
     *       'latitude'               => '',  // float      - Required. Latitude of location
     *       'longitude'              => '',  // float      - Required. Longitude of location
     *       'horizontal_accuracy     => '',  // float      - (Optional). The radius of uncertainty for the location, measured in meters; 0-1500
     *       'heading'                => '',  // int        - (Optional). For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     *       'proximity_alert_radius' => '',  // int        - (Optional). For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     *       'reply_markup'           => '',  // string     - (Optional). A JSON-serialized object for a new inline keyboard.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editmessagelivelocation
     *
     * @return MessageObject|bool
     *
     * @throws TelegramSDKException
     */
    public function editMessageLiveLocation(array $params): MessageObject
    {
        $response = $this->post('editMessageLiveLocation', $params);

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Stop updating a live location message sent by the bot or via the bot.
     *
     * <code>
     * $params = [
     *       'chat_id'            => '',  // int|string - (Optional|Required). Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'message_id'         => '',  // int        - (Optional|Required). Required if inline_message_id is not specified. Identifier of the sent message
     *       'inline_message_id'  => '',  // string     - (Optional|Required). Required if chat_id and message_id are not specified. Identifier of the inline message
     *       'reply_markup'       => '',  // string     - (Optional). A JSON-serialized object for a new inline keyboard.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#stopmessagelivelocation
     *
     * @return MessageObject|bool
     *
     * @throws TelegramSDKException
     */
    public function stopMessageLiveLocation(array $params): MessageObject
    {
        $response = $this->post('stopMessageLiveLocation', $params);

        return new MessageObject($response->getDecodedBody());
    }
}
