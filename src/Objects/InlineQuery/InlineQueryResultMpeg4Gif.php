<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultMpeg4Gif.
 *
 * <code>
 * $params = [
 *   'id'                         => '',
 *   'mpeg4_url'                  => '',
 *   'mpeg4_width'                => '',
 *   'mpeg4_height'               => '',
 *   'mpeg4_duration'             => '',
 *   'thumb_url'                  => '',
 *   'title'                      => '',
 *   'caption'                    => '',
 *   'parse_mode'                 => '',
 *   'reply_markup'               => '',
 *   'input_message_content'      => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif
 *
 * @method $this setId($string)                  Unique identifier for this result, 1-64 bytes
 * @method $this setMpeg4Url($string)            A valid URL for the MP4 file. File size must not exceed 1MB
 * @method $this setMpeg4Width($int)             Optional. Video width
 * @method $this setMpeg4Height($int)            Optional. Video height
 * @method $this setMpeg4Duration($int)          Optional. Video duration
 * @method $this setThumbUrl($string)            URL of the static thumbnail (jpeg or gif) for the result
 * @method $this setTitle($string)               Optional. Title for the result
 * @method $this setCaption($string)             Optional. Caption of the MPEG-4 file to be sent, 0-200 characters
 * @method $this setParseMode($string)           Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup($object)         Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object) Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultMpeg4Gif extends InlineBaseObject
{
    protected $type = 'mpeg4_gif';
}
