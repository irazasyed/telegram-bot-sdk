<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedVoice
 *
 * <code>
 * $params = [
 *   'id'                         => '',
 *   'voice_file_id'              => '',
 *   'title'                      => '',
 *   'reply_markup'               => '',
 *   'input_message_content'      => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedvoice
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setVoiceFileId($string)            A valid file identifier for the voice message
 * @method $this setTitle($string)                  Voice message title
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the photo
 */

class InlineQueryResultCachedVoice extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'voice');
    }
}
