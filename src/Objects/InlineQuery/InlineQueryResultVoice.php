<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultVoice
 *
 * <code>
 * $params = [
 *   'id'                         => '',
 *   'voice_url'                  => '',
 *   'title'                      => '',
 *   'voice_duration'             => '',
 *   'reply_markup'               => '',
 *   'input_message_content'      => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultvoice
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setVoiceUrl($string)               A valid URL for the voice recording
 * @method $this setTitle($string)                  Recording title
 * @method $this setVoiceDuration($int)             Optional. Recording duration in seconds
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultVoice extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'voice');
    }
}
