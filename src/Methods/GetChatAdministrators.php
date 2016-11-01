<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\ChatMember;

/**
 * Class GetChatAdministrators
 *
 * Get a list of administrators in a chat.
 *
 * <code>
 * $params = [
 *   'chat_id'  => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#getchatadministrators
 *
 * @method GetChatAdministrators chatId($chatId) int|string Unique identifier for the target chat or username of the target supergroup
 *      or channel (in the format @channelusername);
 *
 * @method ChatMember[] getResult($dumpAndDie = false)
 */
class GetChatAdministrators extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return collect($this->factory->response()->getResult())
            ->map(function ($admin) {
                return new ChatMember($admin);
            })
            ->all();
    }
}