<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property string|null $name (Optional). User name
 * @property string|null $phoneNumber (Optional). User's phone number
 * @property string|null $email (Optional). User email
 * @property ShippingAddress|null $shippingAddress (Optional). User shipping address
 *
 * @link https://core.telegram.org/bots/api#orderinfo
 */
class OrderInfo extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'shipping_address' => ShippingAddress::class,
        ];
    }
}
