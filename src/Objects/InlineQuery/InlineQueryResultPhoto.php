<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultPhoto
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'photo_url'                => '',
 *   'thumb_url'                => '',
 *   'photo_width'              => '',
 *   'photo_height'             => '',
 *   'title'                    => '',
 *   'description'              => '',
 *   'caption'                  => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultphoto
 *
 * @method $this setId($string)                  Unique identifier for this result, 1-64 Bytes
 * @method $this setPhotoUrl($string)            A valid URL of the photo. Photo must be in jpeg format. Photo size must not exceed 5MB
 * @method $this setThumbUrl($string)            URL of the thumbnail for the photo
 * @method $this setPhotoWidth($int)             Optional. Width of the photo
 * @method $this setPhotoHeight($int)            Optional. Height of the photo
 * @method $this setTitle($string)               Optional. Title for the result
 * @method $this setDescription($string)         Optional. Short description of the result
 * @method $this setCaption($string)             Optional. Caption of the photo to be sent, 0-200 characters
 * @method $this setReplyMarkup($object)         Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object) Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultPhoto extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'photo');
    }
}
