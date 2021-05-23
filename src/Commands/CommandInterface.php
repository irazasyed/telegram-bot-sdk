<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\TelegramService;
use Telegram\Bot\Objects\Update;

/**
 * Interface CommandInterface.
 */
interface CommandInterface
{
    public function getName(): string;

    public function getAliases(): array;

    public function getDescription(): string;

    public function getArguments(): array;

    public function make(TelegramService $telegram, Update $update, array $entity);
}
