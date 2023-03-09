<?php

namespace Telegram\Bot\Objects;

/**
 * Class User.
 *
 * @link https://core.telegram.org/bots/api#user
 *
 * @property int         $id                            Unique identifier for this user or bot.
 * @property bool        $isBot                         True, if this user is a bot
 * @property string      $firstName                     User's or bot's first name.
 * @property string|null $lastName                      (Optional). User's or bot's last name.
 * @property string|null $username                      (Optional). User's or bot's username.
 * @property string|null $languageCode                  (Optional). IETF language tag of the user's language
 * @property bool|null   $canJoinGroups                 (Optional). True, if the bot can be invited to groups. Returned only in getMe.
 * @property bool|null   $canReadAllGroupMessages       (Optional). True, if privacy mode is disabled for the bot. Returned only in getMe.
 * @property bool|null   $supportsInlineQueries         (Optional). True, if the bot supports inline queries. Returned only in getMe.
 */
class User extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
