<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultContact.
 *
 * Represents a contact with a phone number. By default, this contact will be sent by the user.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the contact.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 Bytes
 *   'phone_number'           => '',  //  string                - Required. Contact's phone number
 *   'first_name'             => '',  //  string                - Required. Contact's first name
 *   'last_name'              => '',  //  string                - (Optional). Contact's last name
 *   'vcard'                  => '',  //  string                - (Optional). Additional data about the contact in the form of a vCard, 0-2048 bytes
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the contact
 *   'thumb_url'              => '',  //  string                - (Optional). Url of the thumbnail for the result
 *   'thumb_width'            => '',  //  int                   - (Optional). Thumbnail width
 *   'thumb_height'           => '',  //  int                   - (Optional). Thumbnail height
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcontact
 *
 * @method $this setId(string) Unique identifier for this result, 1-64 Bytes
 * @method $this setPhoneNumber(string) Contact's phone number
 * @method $this setFirstName(string) Contact's first name
 * @method $this setLastName(string) (Optional). Contact's last name
 * @method $this setVcard(string) (Optional). Additional data about the contact in the form of a vCard, 0-2048 bytes
 * @method $this setReplyMarkup(object) (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent(object) (Optional). Content of the message to be sent instead of the contact
 * @method $this setThumbUrl(string) (Optional). Url of the thumbnail for the result
 * @method $this setThumbWidth(int) (Optional). Thumbnail width
 * @method $this setThumbHeight(int) (Optional). Thumbnail height
 */
class InlineQueryResultContact extends InlineBaseObject
{
    protected $type = 'contact';
}
