<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\{
    Chat as ChatObject, ChatMember
};
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class Chat
 */
trait Chat
{
    /**
     * Kick a user from a group or a supergroup.
     *
     * In the case of supergroups, the user will not be able to return to the group on their own using
     * invite links etc., unless unbanned first.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * Note: This will method only work if the ‘All Members Are Admins’ setting is off in the target group.
     * Otherwise members may only be removed by the group's creator or by the member that added them.
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
     * @param array     $params  [
     *
     * @type int|string $chat_id Unique identifier for the target group or username of the target supergroup (in the format @supergroupusername)
     * @type int        $user_id Unique identifier of the target user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function kickChatMember(array $params): bool
    {
        return $this->get('kickChatMember', $params)->getResult();
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel.
     *
     * <code>
     * $params = [
     *   'chat_id'              => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#leavechat
     *
     * @param array     $params  [
     *
     * @type string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function leaveChat(array $params): bool
    {
        return $this->get('leaveChat', $params)->getResult();
    }

    /**
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
     * @param array     $params  [
     *
     * @type int|string $chat_id Unique identifier for the target group or username of the target supergroup (in the format @supergroupusername)
     * @type int        $user_id Unique identifier of the target user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function unbanChatMember(array $params): bool
    {
        return $this->get('unbanChatMember', $params)->getResult();
    }

    /**
     * Get up to date information about the chat (current name of the user for one-on-one conversations,
     * current username of a user, group or channel, etc.).
     *
     * <code>
     * $params = [
     *   'chat_id'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getchat
     *
     * @param array     $params  [
     *
     * @type string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return ChatObject
     */
    public function getChat(array $params): ChatObject
    {
        $response = $this->get('getChat', $params);

        return new ChatObject($response->getDecodedBody());
    }

    /**
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
     * @param array     $params  [
     *
     * @type string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername);
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return ChatMember[]
     */
    public function getChatAdministrators(array $params): array
    {
        $response = $this->get('getChatAdministrators', $params);

        return collect($response->getResult())
            ->map(function ($admin) {
                return new ChatMember($admin);
            })
            ->all();
    }

    /**
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
     * @param array     $params  [
     *
     * @type string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return int
     */
    public function getChatMembersCount(array $params): int
    {
        return $this->get('getChatMembersCount', $params)->getResult();
    }

    /**
     * Get information about a member of a chat.
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
     * @param array     $params  [
     *
     * @type string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @type int        $user_id Unique identifier of the target user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return ChatMember
     */
    public function getChatMember(array $params): ChatMember
    {
        $response = $this->get('getChatMember', $params);

        return new ChatMember($response->getDecodedBody());
    }

    /**
     * exportChatInviteLink
     *
     * <code>
     * $params = [
     *   'chat_id'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @param array     $params  [
     *
     * @type string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return ChatMember
     */
    public function exportChatInviteLink(array $params): ChatMember
    {
        $response = $this->get('exportChatInviteLink', $params);

        return new ChatMember($response->getDecodedBody());
    }
}