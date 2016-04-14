<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedPhoto
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'photo_file_id'            => '',
 *   'title'                    => '',
 *   'description'              => '',
 *   'caption'                  => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedphoto
 *
 * @method $this setId($string)                  Unique identifier for this result, 1-64 Bytes
 * @method $this setPhotoFileId($string)         A valid file identifier of the photo
 * @method $this setTitle($string)               Optional. Title for the result
 * @method $this setDescription($string)         Optional. Short description of the result
 * @method $this setCaption($string)             Optional. Caption of the photo to be sent, 0-200 characters
 * @method $this setReplyMarkup($object)         Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object) Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedPhoto extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'photo');
    }
}
