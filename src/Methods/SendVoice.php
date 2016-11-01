<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class SendVoice
 *
 * Send voice audio files.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'voice'                => InputFile::create($resourceOrFile, $filename),
 *   'caption'              => '',
 *   'duration'             => '',
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendvoice
 *
 * @method SendVoice chatId($chatId) int|string
 * @method SendVoice voice($voice) InputFile|string
 * @method SendVoice caption($caption) string
 * @method SendVoice duration($duration) int
 * @method SendVoice disableNotification($bool) bool
 * @method SendVoice replyToMessageId($replyToMessageId) int
 * @method SendVoice replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 */
class SendVoice extends Method
{
    /** {@inheritdoc} */
    protected $fileUploadField = 'voice';

    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}