<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class EditMessage.
 */
trait EditMessage
{
    /**
     * Edit text messages sent by the bot or via the bot (for inline bots).
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editmessagetext
     *
     * @param array $params [
     *
     * @var int|string $chat_id                  Optional. Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var int        $message_id               Optional. Required if inline_message_id is not specified. Identifier of the sent message
     * @var string     $inline_message_id        Optional. Required if chat_id and message_id are not specified. Identifier of the inline message
     * @var string     $text                     Required. New text of the message.
     * @var string     $parse_mode               Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
     * @var bool       $disable_web_page_preview Optional. Disables link previews for links in this message
     * @var string     $reply_markup             Optional. A JSON-serialized object for an inline keyboard.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return Message|bool
     */
    public function editMessageText(array $params)
    {
        $response = $this->post('editMessageText', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Edit captions of messages sent by the bot or via the bot (for inline bots).
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'caption'                  => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editmessagecaption
     *
     * @param array $params [
     *
     * @var int|string $chat_id           Optional. Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var int        $message_id        Optional. Required if inline_message_id is not specified. Identifier of the sent message
     * @var string     $inline_message_id Optional. Required if chat_id and message_id are not specified. Identifier of the inline message
     * @var string     $caption           Optional. New caption of the message
     * @var string     $reply_markup      Optional. A JSON-serialized object for an inline keyboard.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return Message|bool
     */
    public function editMessageCaption(array $params)
    {
        $response = $this->post('editMessageCaption', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Edit only the reply markup of messages sent by the bot or via the bot (for inline bots).
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     *   'inline_message_id'        => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editmessagereplymarkup
     *
     * @param array $params [
     *
     * @var int|string $chat_id           Optional. Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var int        $message_id        Optional. Required if inline_message_id is not specified. Identifier of the sent message
     * @var string     $inline_message_id Optional. Required if chat_id and message_id are not specified. Identifier of the inline message
     * @var string     $reply_markup      Optional. A JSON-serialized object for an inline keyboard.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return Message|bool
     */
    public function editMessageReplyMarkup(array $params)
    {
        $response = $this->post('editMessageReplyMarkup', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Delete a message, including service messages.
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'message_id'               => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#editmessagereplymarkup
     *
     * @param array $params [
     *
     * @var int|string $chat_id           Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var int        $message_id        Required. Identifier of the message to delete.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return Message|bool
     */
    public function deleteMessage(array $params)
    {
        $response = $this->post('deleteMessage', $params);

        return $response->getResult();
    }
}
