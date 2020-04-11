<?php

namespace Telegram\Bot\Objects;

/**
 * Class Dice.
 *
 * (Yes, we're aware of the “proper” singular of die. But it's awkward, and we decided to help it change. One dice at a time!)
 *
 * @property int    $value     Value of the dice, 1-6
 */
class Dice extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
