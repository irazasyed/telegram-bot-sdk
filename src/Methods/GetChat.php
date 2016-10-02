<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Chat;

/**
 * Class GetChat
 *
 * Use this method to get up to date information about the chat (current name of the user for one-on-one conversations,
 * current username of a user, group or channel, etc.). Returns a Chat object on success.
 *
 * <code>
 * $params = [
 *   'chat_id'  => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#getchat
 *
 * @method GetChat chatId($chatId) int|string Unique identifier for the target chat or username of the
 *         target supergroup or channel (in the format @channelusername);
 *
 * @method Chat getResult($dumpAndDie = false)
 * @method Chat go($dumpAndDie = false) Alias for getResult().
 */
class GetChat extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return Chat::class;
    }
}