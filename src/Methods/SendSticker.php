<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\FileUpload\InputFile;

/**
 * Class SendSticker
 *
 * Send .webp stickers.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'sticker'             => InputFile::create($resourceOrFile, $filename),
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendsticker
 *
 * @method SendSticker chatId($chatId) int|string
 * @method SendSticker sticker(InputFile $sticker)
 * @method SendSticker disableNotification($bool) bool
 * @method SendSticker replyToMessageId($replyToMessageId) int
 * @method SendSticker replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 * @method Message go($dumpAndDie = false) Alias for getResult().
 */
class SendSticker extends Method
{
    /** {@inheritdoc} */
    protected $fileUploadField = 'sticker';

    /** {@inheritdoc} */
    protected function beforeCallHook()
    {
        if (is_file($this->payload['sticker']) && (pathinfo($this->payload['sticker'], PATHINFO_EXTENSION) !== 'webp')) {
            throw new TelegramSDKException('Invalid Sticker Provided. Supported Format: Webp');
        }
    }

    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}