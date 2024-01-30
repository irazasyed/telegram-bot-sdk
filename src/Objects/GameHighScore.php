<?php

namespace Telegram\Bot\Objects;

/**
 * Class GameHighScore.
 *
 * @link https://core.telegram.org/bots/api#gamehighscore
 *
 * @property int $position Position in high score table for the game.
 * @property User $user User
 * @property int $score Score
 */
class GameHighScore extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{user: string}
     */
    public function relations(): array
    {
        return [
            'user' => User::class,
        ];
    }
}
