<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultDocument.
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'title'                    => '',
 *   'caption'                  => '',
 *   'parse_mode'               => '',
 *   'document_url'             => '',
 *   'mime_type'                => '',
 *   'description'              => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 *   'thumb_url'                => '',
 *   'thumb_width'              => '',
 *   'thumb_height'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultdocument
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setTitle($string)                  Title for the result
 * @method $this setCaption($string)                Optional. Caption of the document to be sent, 0-200 characters
 * @method $this setParseMode($string)              Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setDocumentUrl($string)            A valid URL for the file
 * @method $this setMimeType($string)               Mime type of the content of the file, either “application/pdf” or “application/zip”
 * @method $this setDescription($string)            Optional. Short description of the result
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the file
 * @method $this setThumbUrl($string)               Optional. URL of the thumbnail (jpeg only) for the file
 * @method $this setThumbWidth($int)                Optional. Thumbnail width
 * @method $this setThumbHeight($int)               Optional. Thumbnail height */
class InlineQueryResultDocument extends InlineBaseObject
{
    protected $type = 'document';
}
