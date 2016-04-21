<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultArticle
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'title'                    => '',
 *   'input_message_content'    => '',
 *   'reply_markup'             => '',
 *   'url'                      => '',
 *   'hide_url'                 => '',
 *   'description'              => '',
 *   'thumb_url'                => '',
 *   'thumb_width'              => '',
 *   'thumb_height'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultarticle
 *
 * @method $this setId($string)                  Unique identifier for this result, 1-64 Bytes
 * @method $this setTitle($string)               Title of the result
 * @method $this setInputMessageContent($object) Content of the message to be sent.
 * @method $this setReplyMarkup($object)         Optional. Inline keyboard attached to the message
 * @method $this setUrl($string)                 Optional. URL of the result
 * @method $this setHideUrl($bool)               Optional. Pass True, if you don't want the URL to be shown in the message
 * @method $this setDescription($string)         Optional. Short description of the result
 * @method $this setThumbUrl($string)            Optional. Url of the thumbnail for the result
 * @method $this setThumbWidth($int)             Optional. Thumbnail width
 * @method $this setThumbHeight($int)            Optional. Thumbnail height
 */
class InlineQueryResultArticle extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'article');
    }
}
