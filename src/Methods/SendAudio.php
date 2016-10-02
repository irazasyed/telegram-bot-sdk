<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;
use Telegram\Bot\FileUpload\InputFile;

/**
 * Class SendAudio
 *
 * Send regular audio files.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'audio'                => InputFile::create($resourceOrFile, $filename),
 *   'duration'             => '',
 *   'performer'            => '',
 *   'title'                => '',
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendaudio
 *
 * @method SendAudio chatId($chatId) int|string
 * @method SendAudio audio(InputFile $audio) InputFile
 * @method SendAudio duration($duration) int
 * @method SendAudio performer($performer) string
 * @method SendAudio title($title) string
 * @method SendAudio disableNotification($bool) bool
 * @method SendAudio replyToMessageId($replyToMessageId) int
 * @method SendAudio replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 * @method Message go($dumpAndDie = false) Alias for getResult().
 */
class SendAudio extends Method
{
    /** {@inheritdoc} */
    protected $fileUploadField = 'audio';

    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}