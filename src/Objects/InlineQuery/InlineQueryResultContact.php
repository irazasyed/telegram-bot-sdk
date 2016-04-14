<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultContact
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'phone_number'             => '',
 *   'first_name'               => '',
 *   'last_name'                => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 *   'thumb_url'                => '',
 *   'thumb_width'              => '',
 *   'thumb_height'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcontact
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 Bytes
 * @method $this setPhoneNumber($string)            Contact's phone number
 * @method $this setFirstName($string)              Contact's first name
 * @method $this setLastName($string)               Optional. Contact's last name
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the contact
 * @method $this setThumbUrl($string)               Optional. Url of the thumbnail for the result
 * @method $this setThumbWidth($int)                Optional. Thumbnail width
 * @method $this setThumbHeight($int)               Optional. Thumbnail height
 */
class InlineQueryResultContact extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'contact');
    }
}
