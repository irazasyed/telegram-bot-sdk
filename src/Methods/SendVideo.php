<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;
use Telegram\Bot\FileUpload\InputFile;

/**
 * Class SendVideo
 *
 * Send Video File, Telegram clients support mp4 videos (other formats may be sent as Document).
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'video'                => InputFile::create($resourceOrFile, $filename),
 *   'duration'             => '',
 *   'width'                => '',
 *   'height'               => '',
 *   'caption'              => '',
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendvideo
 *
 * @method SendVideo chatId($chatId) int|string
 * @method SendVideo video(InputFile $photo) InputFile
 * @method SendVideo duration($duration) int
 * @method SendVideo width($duration) int
 * @method SendVideo height($duration) int
 * @method SendVideo caption($caption) string
 * @method SendVideo disableNotification($bool) bool
 * @method SendVideo replyToMessageId($replyToMessageId) int
 * @method SendVideo replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 */
class SendVideo extends Method
{
    /** {@inheritdoc} */
    protected $fileUploadField = 'video';

    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}