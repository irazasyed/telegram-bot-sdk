<?php

namespace Telegram\Bot\Tests\Traits;

use Illuminate\Support\Collection;
use Prophecy\Argument;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Update;

trait CommandGenerator
{
    /**
     * @param       $numberRequired
     * @param array $arguments
     *
     * @return Collection
     */
    private function commandGenerator($numberRequired, $arguments = [])
    {
        $range = range(1, $numberRequired, 1);

        return collect($range)
            ->map(function ($int) use ($arguments) {
                $mockCommand = $this->prophesize(Command::class);
                $mockCommand->getName()->willReturn("MockCommand$int");
                $mockCommand->getAliases()->willReturn(["MockAlias$int"]);
                $mockCommand->getPattern()->willReturn('');
                $mockCommand->getArguments()->willReturn([]);
                $mockCommand->setArguments(Argument::type('array'))->willReturn($mockCommand);
                $mockCommand->make(Argument::type(Api::class), Argument::type(Update::class),
                    Argument::withEntry('type', 'bot_command'))->willReturn(null);

                return $mockCommand->reveal();
            });
    }
}
