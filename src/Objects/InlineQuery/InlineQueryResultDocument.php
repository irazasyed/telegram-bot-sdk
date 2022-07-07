<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultDocument.
 *
 * Represents a link to a file. By default, this file will be sent by the user with an optional caption.
 * Alternatively, you can use input_message_content to send a message with the specified content instead of the file.
 * Currently, only .PDF and .ZIP files can be sent using this method.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 bytes
 *   'title'                  => '',  //  string                - Required. Title for the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the document to be sent, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'caption_entities'       => '',  //  array                 - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 *   'document_url'           => '',  //  string                - Required. A valid URL for the file
 *   'mime_type'              => '',  //  string                - Required. Mime type of the content of the file, either “application/pdf” or “application/zip”
 *   'description'            => '',  //  string                - (Optional). Short description of the result
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the file
 *   'thumb_url'              => '',  //  string                - (Optional). URL of the thumbnail (jpeg only) for the file
 *   'thumb_width'            => '',  //  int                   - (Optional). Thumbnail width
 *   'thumb_height'           => '',  //  int                   - (Optional). Thumbnail height
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultdocument
 *
 * @method $this setId(string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setTitle(string)                  Title for the result
 * @method $this setCaption(string)                (Optional). Caption of the document to be sent, 0-200 characters
 * @method $this setParseMode(string)              (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setDocumentUrl(string)            A valid URL for the file
 * @method $this setMimeType(string)               Mime type of the content of the file, either “application/pdf” or “application/zip”
 * @method $this setDescription(string)            (Optional). Short description of the result
 * @method $this setReplyMarkup(object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent(object)    (Optional). Content of the message to be sent instead of the file
 * @method $this setThumbUrl(string)               (Optional). URL of the thumbnail (jpeg only) for the file
 * @method $this setThumbWidth(int)                (Optional). Thumbnail width
 * @method $this setThumbHeight(int)               (Optional). Thumbnail height
 */
class InlineQueryResultDocument extends InlineBaseObject
{
    protected $type = 'document';
}
