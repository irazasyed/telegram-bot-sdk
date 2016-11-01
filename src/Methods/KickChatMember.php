<?php
namespace Telegram\Bot\Methods;

/**
 * Class KickChatMember
 *
 * Kick a user from a group or a supergroup.
 *
 * In the case of supergroups, the user will not be able to return to the group on their own using
 * invite links etc., unless unbanned first.
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
 * @link https://core.telegram.org/bots/api#kickchatmember
 *
 * @method KickChatMember chatId($chatId) int|string
 * @method KickChatMember userId($chatId) int
 *
 * @method bool getResult($dumpAndDie = false)
 */
class KickChatMember extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return true;
    }
}