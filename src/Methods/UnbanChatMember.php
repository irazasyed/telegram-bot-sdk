<?php
namespace Telegram\Bot\Methods;

/**
 * Class UnbanChatMember
 *
 * Unban a previously kicked user in a supergroup.
 *
 * The user will not return to the group automatically, but will be able to join via link, etc.
 *
 * The bot must be an administrator in the group for this to work.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'user_id'              => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#unbanchatmember
 *
 * @method UnbanChatMember chatId($chatId) int|string
 * @method UnbanChatMember userId($chatId) int
 *
 * @method bool getResult($dumpAndDie = false)
 */
class UnbanChatMember extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return true;
    }
}