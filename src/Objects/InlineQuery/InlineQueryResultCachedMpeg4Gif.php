<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedMpeg4Gif.
 *
 * <code>
 * $params = [
 *   'id'                         => '',
 *   'mpeg4_file_id'              => '',
 *   'title'                      => '',
 *   'caption'                    => '',
 *   'parse_mode'                 => '',
 *   'reply_markup'               => '',
 *   'input_message_content'      => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedmpeg4gif
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setMpeg4FileId($string)            A valid file identifier for the MP4 file
 * @method $this setTitle($string)                  Optional. Title for the result
 * @method $this setCaption($string)                Optional. Caption of the MPEG-4 file to be sent, 0-200 characters
 * @method $this setParseMode($string)              Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedMpeg4Gif extends InlineBaseObject
{
    protected $type = 'mpeg4_gif';
}
