<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultGif
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'gif_url'                  => '',
 *   'gif_width'                => '',
 *   'gif_height'               => '',
 *   'thumb_url'                => '',
 *   'title'                    => '',
 *   'caption'                  => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultgif
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setGifUrl($string)                 A valid URL for the GIF file. File size must not exceed 1MB
 * @method $this setGifWidth($int)                  Optional. Width of the GIF
 * @method $this setGifHeight($int)                 Optional. Height of the GIF
 * @method $this setThumbUrl($string)               URL of the static thumbnail for the result (jpeg or gif)
 * @method $this setTitle($string)                  Optional. Title for the result
 * @method $this setCaption($string)                Optional. Caption of the GIF file to be sent, 0-200 characters
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultGif extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'gif');
    }
}
