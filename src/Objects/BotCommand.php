<?php

namespace Telegram\Bot\Objects;

/**
 * Class BotCommand.
 *
 * This object represents a bot command
 *
 * @property string $command Text of the command, 1-32 characters. Can contain only lowercase English letters, digits and underscores.
 * @property string $description Description of the command, 3-256 characters.
 */
class BotCommand extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
