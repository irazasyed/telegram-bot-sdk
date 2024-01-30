<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property string $firstName First Name
 * @property string $lastName Last Name
 * @property string|null $middleName (Optional). Middle Name
 * @property string $birthDate Date of birth in DD.MM.YYYY format
 * @property string $gender Gender, male or female
 * @property string $countryCode Citizenship (ISO 3166-1 alpha-2 country code)
 * @property string $residenceCountryCode Country of residence (ISO 3166-1 alpha-2 country code)
 * @property string $firstNameNative First Name in the language of the user's country of residence
 * @property string $lastNameNative Last Name in the language of the user's country of residence
 * @property string|null $middleNameNative (Optional). Middle Name in the language of the user's country of residence
 *
 * @link https://core.telegram.org/bots/api#personaldetails
 */
class PersonalDetails extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [
        ];
    }
}
