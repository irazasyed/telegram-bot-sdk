<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class SendChatAction
 *
 * Broadcast a Chat Action.
 *
 * <code>
 * $params = [
 *   'chat_id'  => '',
 *   'action'   => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendchataction
 *
 * @method SendChatAction chatId($chatId) int|string
 * @method SendChatAction action($action) string
 *
 * @method bool getResult($dumpAndDie = false)
 */
class SendChatAction extends Method
{
    /** {@inheritdoc} */
    protected function beforeCallHook()
    {
        $validActions = [
            'typing',
            'upload_photo',
            'record_video',
            'upload_video',
            'record_audio',
            'upload_audio',
            'upload_document',
            'find_location',
        ];

        if (isset($this->payload['action']) && !in_array($this->payload['action'], $validActions)) {
            throw new TelegramSDKException('Invalid Action! Accepted value: '.implode(', ', $validActions));
        }
    }

    /** {@inheritdoc} */
    protected function returns()
    {
        return true;
    }
}