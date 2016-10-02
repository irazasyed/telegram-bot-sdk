<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\ChatMember;

/**
 * Class GetChatMember
 *
 * Use this method to get information about a member of a chat.
 * Returns a ChatMember object on success.
 *
 * <code>
 * $params = [
 *   'chat_id'  => '',
 *   'user_id'  => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#getchatmember
 *
 * @method GetChatMember chatId($chatId) int|string Unique identifier for the target chat or username of the
 *         target supergroup or channel (in the format @channelusername).
 * @method GetChatMember userId($userId) int Unique identifier of the target user.
 *
 * @method ChatMember getResult($dumpAndDie = false)
 * @method ChatMember go($dumpAndDie = false) Alias for getResult().
 */
class GetChatMember extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return ChatMember::class;
    }
}