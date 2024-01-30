<?php

namespace Telegram\Bot\Objects;

/**
 * Class Dice.
 *
 * (Yes, we're aware of the “proper” singular of die. But it's awkward, and we decided to help it change. One dice at a time!)
 *
 * @link https://core.telegram.org/bots/api#dice
 *
 * @property string $emoji Emoji on which the dice throw animation is based
 * @property int $value Value of the dice, 1-6 for “🎲”, “🎯” and “🎳” base emoji, 1-5 for “🏀” and “⚽” base emoji, 1-64 for “🎰” base emoji
 */
class Dice extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
