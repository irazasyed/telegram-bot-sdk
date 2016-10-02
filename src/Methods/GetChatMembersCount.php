<?php
namespace Telegram\Bot\Methods;

/**
 * Class GetChatMembersCount
 *
 * Get the number of members in a chat
 *
 * <code>
 * $params = [
 *   'chat_id'  => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#getchatmemberscount
 *
 * @method GetChatMembersCount chatId($chatId) int|string Unique identifier for the target chat or username of the
 *         target supergroup or channel (in the format @channelusername);
 *
 * @method int getResult($dumpAndDie = false)
 * @method int go($dumpAndDie = false) Alias for getResult().
 */
class GetChatMembersCount extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return $this->factory->response()->getResult();
    }
}