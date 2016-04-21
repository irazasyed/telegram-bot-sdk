<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedsticker
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'sticker_file_id'          => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedsticker
 *
 * @method $this setId($string)                  Unique identifier for this result, 1-64 Bytes
 * @method $this setStickerFileId($string)       A valid file identifier of the sticker
 * @method $this setReplyMarkup($object)         Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object) Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedSticker extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'sticker');
    }
}
