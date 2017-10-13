<?php

namespace Telegram\Bot\Objects\Payments;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property string $label               Portion label
 * @property int    $amount              Price of the product in the smallest units of the currency (integer, not float/double).
 *
 * @link https://core.telegram.org/bots/api#labeledprice
 */
class LabeledPrice extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
        ];
    }
}
