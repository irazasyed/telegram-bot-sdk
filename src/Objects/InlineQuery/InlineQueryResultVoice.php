<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultVoice.
 *
 * Represents a link to a voice recording in an .OGG container encoded with OPUS.
 * By default, this voice recording will be sent by the user. Alternatively, you can
 * use input_message_content to send a message with the specified content instead of the
 * voice message.
 *
 * <code>
 * [
 *   'id'                      => '',  //  string                - Required. Unique identifier for this result, 1-64 bytes
 *   'voice_url'               => '',  //  string                - Required. A valid URL for the voice recording
 *   'title'                   => '',  //  string                - Required. Recording title
 *   'caption'                 => '',  //  string                - (Optional). Caption, 0-200 characters
 *   'parse_mode'              => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'caption_entities'       => '',   //  array                 - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 *   'voice_duration'          => '',  //  int                   - (Optional). Recording duration in seconds
 *   'reply_markup'            => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'   => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultvoice
 *
 * @method $this setId(string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setVoiceUrl(string)               A valid URL for the voice recording
 * @method $this setTitle(string)                  Recording title
 * @method $this setCaption(string)                (Optional). Caption, 0-200 characters
 * @method $this setParseMode(string)              (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setVoiceDuration(int)             (Optional). Recording duration in seconds
 * @method $this setReplyMarkup(object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent(object)    (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultVoice extends InlineBaseObject
{
    protected $type = 'voice';
}
