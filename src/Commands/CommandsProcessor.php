<?php
declare(strict_types=1);

namespace Telegram\Bot\Commands;

use Telegram\Bot\Objects\Update;

interface CommandsProcessor
{
    /**
     * Handle bot message
     *
     * @param Update $update
     * @return CommandInterface[]|array Commands that match to given message
     */
    public function handle(Update $update): array;
}