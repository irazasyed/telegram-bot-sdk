<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;
use Telegram\Bot\FileUpload\InputFile;

/**
 * Class SendPhoto
 *
 * Makes an API call to sendPhoto endpoint.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'photo'                => InputFile::create($resourceOrFile, $filename),
 *   'caption'              => '',
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendphoto
 *
 * @method SendPhoto chatId($chatId) int|string
 * @method SendPhoto photo(InputFile $photo) InputFile
 * @method SendPhoto caption($caption) string
 * @method SendPhoto disableNotification($bool) bool
 * @method SendPhoto replyToMessageId($replyToMessageId) int
 * @method SendPhoto replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 */
class SendPhoto extends Method
{
    /** {@inheritdoc} */
    protected $fileUploadField = 'photo';

    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}