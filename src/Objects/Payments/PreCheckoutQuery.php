<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\BaseObject;
use Telegram\Bot\Objects\User;

/**
 * Class PreCheckoutQuery
 *
 * @link https://core.telegram.org/bots/api#precheckoutquery
 *
 * @property string $id Unique query identifier
 * @property User $from User who sent the query.
 * @property string $currency Three-letter ISO 4217 currency code
 * @property int $totalAmount Total price in the smallest units of the currency (integer, not float/double)
 * @property string $invoicePayload Bot specified invoice payload
 * @property string|null $shippingOptionId (Optional). Identifier of the shipping option chosen by the user
 * @property OrderInfo|null $orderInfo (Optional). Order info provided by the user
 */
class PreCheckoutQuery extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{from: string, order_info: string}
     */
    public function relations(): array
    {
        return [
            'from' => User::class,
            'order_info' => OrderInfo::class,
        ];
    }

    public function objectType(): ?string
    {
        return $this->findType(['shipping_option_id', 'order_info']);
    }
}
