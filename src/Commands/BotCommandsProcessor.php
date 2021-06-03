<?php
declare(strict_types=1);

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Telegram\Bot\Objects\Update;

class BotCommandsProcessor implements CommandsProcessor
{
    public function handle(Update $update): array
    {
        $parser = new CommandParser();

        $message = $update->getMessage();

        if ($message->has('entities')) {
            return $this->parseCommandsIn($message)
                ->mapWithKeys(function (array $entity) use ($parser, $update) {

                    $command = $parser->parse(
                        $update->getMessage()->text,
                        $entity['offset'],
                        $entity['length']
                    );

                    return [$command => $entity];
                })->all();
        }

        return [];
    }

    /**
     * Returns all bot_commands detected in the update.
     *
     * @param Collection $message
     * @return Collection
     */
    protected function parseCommandsIn(Collection $message): Collection
    {
        return collect($message->get('entities'))
            ->filter(function ($entity) {
                return $entity['type'] === 'bot_command';
            });
    }
}