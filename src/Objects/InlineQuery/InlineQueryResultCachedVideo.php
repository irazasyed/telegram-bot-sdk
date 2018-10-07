<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedVideo.
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'video_file_id             => '',
 *   'title'                    => '',
 *   'description'              => '',
 *   'caption'                  => '',
 *   'parse_mode'               => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedvideo
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setVideoFileId($string)            A valid file identifier for the video file
 * @method $this setTitle($string)                  Title for the result
 * @method $this setDescription($string)            Optional. Short description of the result
 * @method $this setCaption($string)                Optional. Caption of the video to be sent, 0-200 characters
 * @method $this setParseMode($string)              Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedVideo extends InlineBaseObject
{
    protected $type = 'video';
}
