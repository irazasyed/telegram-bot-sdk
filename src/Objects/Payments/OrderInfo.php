<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property string          $name                 (Optional). User name
 * @property string          $phoneNumber          (Optional). User's phone number
 * @property string          $email                (Optional). User email
 * @property ShippingAddress $shippingAddress      (Optional). User shipping address
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
