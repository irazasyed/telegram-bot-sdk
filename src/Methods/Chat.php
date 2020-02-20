<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Chat as ChatObject;
use Telegram\Bot\Objects\ChatMember;
use Telegram\Bot\Objects\ChatPermissions;
use Telegram\Bot\Traits\Http;

/**
 * Class Chat.
 * @mixin Http
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
     *   'until_date'           => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#kickchatmember
     *
     * @param array    $params     [
     *
     * @var int|string $chat_id    Required. Unique identifier for the target group or username of the target supergroup (in the format @supergroupusername)
     * @var int        $user_id    Required. Unique identifier of the target user.
     * @var int        $until_date (Optional). Unique identifier of the target user.
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
     * Export an invite link to a supergroup or a channel.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'              => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#exportchatinvitelink
     *
     * @param array    $params  [
     *
     * @var string|int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return string
     */
    public function exportChatInviteLink(array $params): string
    {
        $response = $this->post('exportChatInviteLink', $params);

        return $response->getResult();
    }

    /**
     * Set a new profile photo for the chat.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'              => ''
     *   'photo'                => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setchatphoto
     *
     * @param array    $params  [
     *
     * @var string|int $chat_id Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile  $photo   Required. New chat photo, uploaded using multipart/form-data
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setChatPhoto(array $params): bool
    {
        $response = $this->post('setChatPhoto', $params);

        return $response->getResult();
    }

    /**
     * Delete a chat photo.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'              => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#deletechatphoto
     *
     * @param array    $params  [
     *
     * @var string|int $chat_id Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function deleteChatPhoto(array $params): bool
    {
        $response = $this->post('deleteChatPhoto', $params);

        return $response->getResult();
    }

    /**
     * Set the title of a chat.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'              => ''
     *   'title'                => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setchatdescription
     *
     * @param array    $params  [
     *
     * @var string|int $chat_id Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var string     $photo   Required. New chat title, 1-255 characters
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setChatTitle(array $params): bool
    {
        $response = $this->post('setChatTitle', $params);

        return $response->getResult();
    }

    /**
     * Set the description of a supergroup or a channel.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'              => ''
     *   'description'          => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setchatdescription
     *
     * @param array    $params      [
     *
     * @var string|int $chat_id     Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var string     $description (Optional). New chat description, 0-255 characters.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setChatDescription(array $params): bool
    {
        $response = $this->post('setChatDescription', $params);

        return $response->getResult();
    }

    /**
     * Pin a message in a group, a supergroup, or a channel.
     *
     * The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’ admin right in the supergroup
     * or ‘can_edit_messages’ admin right in the channel.
     *
     * <code>
     * $params = [
     *   'chat_id'                   => ''
     *   'message_id'                => ''
     *   'disable_notification'      => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#pinchatmessage
     *
     * @param array    $params               [
     *
     * @var string|int $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var int        $message_id           Required. Identifier of a message to pin
     * @var bool       $disable_notification (Optional). Pass True, if it is not necessary to send a notification to all group members about the new pinned message
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function pinChatMessage(array $params): bool
    {
        $response = $this->post('pinChatMessage', $params);

        return $response->getResult();
    }

    /**
     * Unpin a message in a group, a supergroup, or a channel.
     *
     * The bot must be an administrator in the chat for this to work and must have the ‘can_pin_messages’ admin right in the supergroup
     * or ‘can_edit_messages’ admin right in the channel.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'              => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#unpinchatmessage
     *
     * @param array    $params  [
     *
     * @var string|int $chat_id Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function unpinChatMessage(array $params): bool
    {
        $response = $this->post('unpinChatMessage', $params);

        return $response->getResult();
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
     * @param array    $params  [
     *
     * @var string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
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
     * @param array    $params  [
     *
     * @var int|string $chat_id Unique identifier for the target group or username of the target supergroup (in the format @supergroupusername)
     * @var int        $user_id Unique identifier of the target user.
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
     * Restrict a user in a supergroup.
     *
     * Pass True for all boolean parameters to lift restrictions from a user.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'                     => '',
     *   'user_id'                     => '',
     *   'until_date'                  => '',
     *   'can_send_messages'           => '',
     *   'can_send_media_messages'     => '',
     *   'can_send_other_messages'     => '',
     *   'can_add_web_page_previews'   => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param array    $params                    [
     *
     * @var int|string      $chat_id        Required. Unique identifier for the target group or username of the target supergroup (in the format @supergroupusername)
     * @var int             $user_id        Required. Unique identifier of the target user.
     * @var ChatPermissions $permissions    Required.  New user permissions
     * @var int             $until_date     (Optional). Date when restrictions will be lifted for the user, unix time. If user is restricted for more than 366 days or less than 30 seconds from the current time, they are considered to be restricted forever.
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function restrictChatMember(array $params): bool
    {
        $response = $this->post('restrictChatMember', $params);

        return $response->getResult();
    }

    /**
     * Promote or demote a user in a supergroup or a channel.
     *
     * Pass False for all boolean parameters to demote a user.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'               => '',
     *   'user_id'               => '',
     *   'can_change_info'       => '',
     *   'can_post_messages'     => '',
     *   'can_edit_messages'     => '',
     *   'can_delete_messages'   => '',
     *   'can_invite_users'      => '',
     *   'can_restrict_members'  => '',
     *   'can_pin_messages'      => '',
     *   'can_promote_members'   => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#restrictchatmember
     *
     * @param array    $params               [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target group or username of the target supergroup (in the format @supergroupusername)
     * @var int        $user_id              Required. Unique identifier of the target user.
     * @var bool       $can_change_info      (Optional). Pass True, if the administrator can change chat title, photo and other settings
     * @var bool       $can_post_messages    (Optional). Pass True, if the administrator can create channel posts, channels only
     * @var bool       $can_edit_messages    (Optional). Pass True, if the administrator can edit messages of other users, channels only
     * @var bool       $can_delete_messages  (Optional). Pass True, if the administrator can delete messages of other users
     * @var bool       $can_invite_users     (Optional). Pass True, if the administrator can invite new users to the chat
     * @var bool       $can_restrict_members (Optional). Pass True, if the administrator can restrict, ban or unban chat members
     * @var bool       $can_pin_messages     (Optional). Pass True, if the administrator can pin messages, supergroups only
     * @var bool       $can_promote_members  (Optional). Pass True, if the administrator can add new administrators with a subset of his own privileges or demote administrators that he has promoted, directly or indirectly (promoted by administrators that were appointed by him)
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function promoteChatMember(array $params): bool
    {
        $response = $this->post('promoteChatMember', $params);

        return $response->getResult();
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot.
     *
     * Returns True on success.
     *
     * <code>
     * $params = [
     *   'chat_id'               => '',
     *   'user_id'               => '',
     *   'custom_title'           => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     *
     * @param array         $params      [
     *
     * @var int|string      $chat_id      Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @var int             $user_id      Required. Unique identifier of the target user
     * @var string          $custom_title Required. New custom title for the administrator; 0-16 characters, emoji are not allowed
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setChatAdministratorCustomTitle(array $params): bool
    {
        $response = $this->post('setChatAdministratorCustomTitle', $params);

        return $response->getResult();
    }

    /**
     * Use this method to set default chat permissions for all members.
     * The bot must be an administrator in the group or a supergroup for this to work and
     * must have the can_restrict_members admin rights.
     *
     * <code>
     * $params = [
     *   'chat_id'               => '',
     *   'permissions'           => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setchatpermissions
     *
     * @param array         $params      [
     *
     * @var int|string      $chat_id     Required. Unique identifier for the target group or username of the target supergroup (in the format @supergroupusername)
     * @var ChatPermissions $permissions Required. New default chat permissions
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setChatPermissions(array $params): bool
    {
        $response = $this->post('setChatPermissions', $params);

        return $response->getResult();
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
     * @param array    $params  [
     *
     * @var string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername)
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
     * @param array    $params  [
     *
     * @var string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername);
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
     * Get the number of members in a chat.
     *
     * <code>
     * $params = [
     *   'chat_id'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getchatmemberscount
     *
     * @param array    $params  [
     *
     * @var string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
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
     * @param array    $params  [
     *
     * @var string|int $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format @channelusername).
     * @var int        $user_id Unique identifier of the target user.
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
     * Set a new group sticker set for a supergroup.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'                   => ''
     *   'sticker_set_name'          => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setchatstickerset
     *
     * @param array    $params           [
     *
     * @var string|int $chat_id          Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     * @var int        $sticker_set_name Required. Name of the sticker set to be set as the group sticker set
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setChatStickerSet(array $params): bool
    {
        $response = $this->post('setChatStickerSet', $params);

        return $response->getResult();
    }

    /**
     * Delete a group sticker set from a supergroup.
     *
     * The bot must be an administrator in the group for this to work.
     *
     * <code>
     * $params = [
     *   'chat_id'                   => ''
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#deletechatstickerset
     *
     * @param array    $params  [
     *
     * @var string|int $chat_id Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function deleteChatStickerSet(array $params): bool
    {
        $response = $this->post('deleteChatStickerSet', $params);

        return $response->getResult();
    }
}
