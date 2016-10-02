<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;
use Telegram\Bot\FileUpload\InputFile;

/**
 * Class SendDocument
 *
 * Send general files.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'document'             => InputFile::create($resourceOrFile, $filename),
 *   'caption'              => '',
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#senddocument
 *
 * @method SendDocument chatId($chatId) int|string
 * @method SendDocument document(InputFile $document) InputFile
 * @method SendDocument caption($caption) string
 * @method SendDocument disableNotification($bool) bool
 * @method SendDocument replyToMessageId($replyToMessageId) int
 * @method SendDocument replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 * @method Message go($dumpAndDie = false) Alias for getResult().
 */
class SendDocument extends Method
{
    /** {@inheritdoc} */
    protected $fileUploadField = 'document';

    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}