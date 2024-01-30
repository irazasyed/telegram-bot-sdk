<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property string $streetLine1 First line for the address
 * @property string|null $streetLine2 (Optional). Second line for the address
 * @property string $city City
 * @property string|null $state (Optional). State
 * @property string $countryCode ISO 3166-1 alpha-2 country code
 * @property string $postCode Address post code
 *
 * @link https://core.telegram.org/bots/api#residentialaddress
 */
class ResidentialAddress extends BaseObject
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
