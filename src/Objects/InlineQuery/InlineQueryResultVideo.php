<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultVideo
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'video_url'                => '',
 *   'mime_type'                => '',
 *   'thumb_url'                => '',
 *   'title'                    => '',
 *   'caption'                  => '',
 *   'video_width'              => '',
 *   'video_height'             => '',
 *   'video_duration'           => '',
 *   'description'              => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultvideo
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 bytes
 * @method $this setVideoUrl($string)               A valid URL for the embedded video player or video file
 * @method $this setMimeType($string)               Mime type of the content of video url, “text/html” or “video/mp4”
 * @method $this setThumbUrl($string)               URL of the thumbnail (jpeg only) for the video
 * @method $this setTitle($string)                  Title for the result
 * @method $this setCaption($string)                Optional. Caption of the video to be sent, 0-200 characters
 * @method $this setVideoWidth($int)                Optional. Video width
 * @method $this setVideoHeight($int)               Optional. Video height
 * @method $this setVideoDuration($int)             Optional. Video duration in seconds
 * @method $this setDescription($string)            Optional. Short description of the result
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the photo
 */
class InlineQueryResultVideo extends InlineBaseObject
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'video');
    }
}
