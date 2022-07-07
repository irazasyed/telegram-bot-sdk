<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedGif.
 *
 * Represents a link to an animated GIF file stored on the Telegram servers. By default, this animated GIF file will
 * be sent by the user with an optional caption. Alternatively, you can use input_message_content to send a message
 * with specified content instead of the animation.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 bytes
 *   'gif_file_id'            => '',  //  string                - Required. A valid file identifier for the GIF file
 *   'title'                  => '',  //  string                - (Optional). Title for the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the GIF file to be sent, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'caption_entities'       => '',  //  array                 - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedgif
 *
 * @method $this setId(string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setGifFileId(string)              A valid file identifier for the GIF file
 * @method $this setTitle(string)                  (Optional). Title for the result
 * @method $this setCaption(string)                (Optional). Caption of the GIF file to be sent, 0-200 characters
 * @method $this setParseMode(string)              (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup(object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent(object)    (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedGif extends InlineBaseObject
{
    protected $type = 'gif';
}
