<?php

namespace Telegram\Bot\Objects;

/**
 * Class Contact.
 *
 * @link https://core.telegram.org/bots/api#contact
 *
 * @property string      $phoneNumber    Contact's phone number.
 * @property string      $firstName      Contact's first name.
 * @property string|null $lastName       (Optional). Contact's last name.
 * @property int|null    $userId         (Optional). Contact's user identifier in Telegram.
 * @property string|null $vcard          (Optional). Additional data about the contact in the form of a vCard.
 */
class Contact extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
