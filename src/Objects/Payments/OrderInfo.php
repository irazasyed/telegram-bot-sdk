<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#orderinfo
 *
 * @property string|null          $name            (Optional). User name
 * @property string|null          $phoneNumber     (Optional). User's phone number
 * @property string|null          $email           (Optional). User email
 * @property ShippingAddress|null $shippingAddress (Optional). User shipping address
 */
class OrderInfo extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{shipping_address: string}
     */
    public function relations(): array
    {
        return [
            'shipping_address' => ShippingAddress::class,
        ];
    }
}
