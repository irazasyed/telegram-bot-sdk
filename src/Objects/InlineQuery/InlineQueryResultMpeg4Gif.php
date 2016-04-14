<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultMpeg4Gif
 *
 * <code>
 * $params = [
 *   'id'                         => '',
 *   'mpeg4_url'                  => '',
 *   'mpeg4_width'                => '',
 *   'mpeg4_height'               => '',
 *   'thumb_url'                  => '',
 *   'title'                      => '',
 *   'caption'                    => '',
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
 * @method $this setThumbUrl($string)            URL of the static thumbnail (jpeg or gif) for the result
 * @method $this setTitle($string)               Optional. Title for the result
 * @method $this setCaption($string)             Optional. Caption of the MPEG-4 file to be sent, 0-200 characters
 * @method $this setReplyMarkup($object)         Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object) Optional. Content of the message to be sent instead of the photo
 */

class InlineQueryResultMpeg4Gif extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'mpeg4_gif');
    }
}
