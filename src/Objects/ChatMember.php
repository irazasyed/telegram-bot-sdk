<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatMember.
 *
 * @property User   $user                            Information about the user.
 * @property string $status                          The member's status in the chat. Can be “creator”, “administrator”, “member”, “left” or “kicked”
 * @property string $customTitle                     (Optional). Owner and administrators only. Custom title for this user
 * @property int    $untilDate                       (Optional). Restictred and kicked only. Date when restrictions will be lifted for this user, unix time
 * @property bool   $canBeEdited                     (Optional). Administrators only. True, if the bot is allowed to edit administrator privileges of that user
 * @property bool   $canPostMessages                 (Optional). Administrators only. True, if the administrator can post in the channel, channels only
 * @property bool   $canEditMessages                 (Optional). Administrators only. True, if the administrator can edit messages of other users, channels only
 * @property bool   $canDeleteMessages               (Optional). Administrators only. True, if the administrator can delete messages of other users
 * @property bool   $canPromoteMembers               (Optional). Administrators only. True, if the administrator can add new administrators with a subset of his own privileges or demote administrators that he has promoted, directly or indirectly (promoted by administrators that were appointed by the user)
 * @property bool   $canChangeInfo                   (Optional). Administrators and restricted only. True, if the administrator can change the chat title, photo and other settings
 * @property bool   $canInviteUsers                  (Optional). Administrators and restricted only. True, if the administrator can invite new users to the chat
 * @property bool   $canPinMessages                  (Optional). Administrators and restricted only. True, if the administrator can pin messages, supergroups only
 * @property bool   $isMember                        (Optional). Restricted only. True, if the user is a member of the chat at the moment of the request
 * @property bool   $canSendMessages                 (Optional). Restricted only. True, if the user can send text messages, contacts, locations and venues
 * @property bool   $canSendMediaMessages            (Optional). Restricted only. True, if the user can send audios, documents, photos, videos, video notes and voice notes, implies can_send_messages
 * @property bool   $canSendPolls                    (Optional). Restricted only. True, if the user is allowed to send polls
 * @property bool   $canSendOtherMessages            (Optional). Restricted only. True, if the user can send animations, games, stickers and use inline bots, implies can_send_media_messages
 * @property bool   $canAddWebPagePreviews           (Optional). Restricted only. True, if user may add web page previews to his messages, implies can_send_media_messages
 */
class ChatMember extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'user' => User::class,
        ];
    }
}
