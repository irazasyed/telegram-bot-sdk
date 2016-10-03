<?php

namespace Telegram\Bot\Objects;

/**
 * Class Game.
 *
 * @property string          $title        Title of the game.
 * @property string          $description  Description of the game.
 * @property PhotoSize[]     $photo        Photo that will be displayed in the game message in chats.
 * @property string          $text         (Optional). Brief description of the game or high scores
 *           included in the game message. Can be automatically edited to include current high scores for the game when
 *           the bot calls setGameScore, or manually edited using editMessageText. 0-4096 characters.
 * @property MessageEntity[] $textEntities (Optional). Special entities that appear in text, such as
 *           usernames, URLs, bot commands, etc.
 * @property Animation       $animation    (Optional). Animation that will be displayed in the game
 *           message in chats. Upload via BotFather.
 */
class Game extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'photo'         => PhotoSize::class,
            'text_entities' => MessageEntity::class,
            'animation'     => Animation::class,
        ];
    }
}
