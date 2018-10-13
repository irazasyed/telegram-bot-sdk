<?php

namespace Telegram\Bot\Objects;

/**
 * Class Contact.
 *
 *
 * @property string   $phoneNumber    Contact's phone number.
 * @property string   $firstName      Contact's first name.
 * @property string   $lastName       (Optional). Contact's last name.
 * @property int      $userId         (Optional). Contact's user identifier in Telegram.
 * @property string   $vcard          (Optional). Additional data about the contact in the form of a vCard.
 */
class Contact extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
