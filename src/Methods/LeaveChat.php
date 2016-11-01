<?php
namespace Telegram\Bot\Methods;

/**
 * Class LeaveChat
 *
 * Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
 *
 * <code>
 * $params = [
 *   'chat_id'  => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#leavechat
 *
 * @method LeaveChat chatId($chatId) int|string Unique identifier for the target chat or username of the
 *         target supergroup or channel (in the format @channelusername);
 *
 * @method bool getResult($dumpAndDie = false)
 */
class LeaveChat extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return true;
    }
}