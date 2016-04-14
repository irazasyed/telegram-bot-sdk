<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedMpeg4Gif
 *
 * <code>
 * $params = [
 *   'id'                         => '',
 *   'mpeg4_file_id'              => '',
 *   'title'                      => '',
 *   'caption'                    => '',
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
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the photo
 */

class InlineQueryResultCachedMpeg4Gif extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'mpeg4_gif');
    }
}
