<?php
declare(strict_types=1);

namespace Telegram\Bot\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;

class CommandParser
{
    /**
     * Parse a Command for a Match.
     *
     * @param string $text
     * @param int $offset
     * @param int $length
     *
     * @return string
     */
    public function parse(string $text, int $offset, int $length): string
    {
        if (trim($text) === '') {
            throw new InvalidArgumentException('Message is empty, Cannot parse for command');
        }

        $command = substr(
            $text,
            $offset + 1,
            $length - 1
        );

        // When in group - Ex: /command@MyBot
        if (Str::contains($command, '@') && Str::endsWith($command, ['bot', 'Bot'])) {
            $command = explode('@', $command);
            $command = $command[0];
        }

        return $command;
    }
}