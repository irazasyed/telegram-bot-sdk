<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#shippingaddress
 *
 * @property string $countryCode ISO 3166-1 alpha-2 country code
 * @property string $state State, if applicable
 * @property string $city City
 * @property string $streetLine1 First line for the address.
 * @property string $streetLine2 Second line for the address.
 * @property string $postCode Address post code
 */
class ShippingAddress extends BaseObject
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
