<?php

namespace Telegram\Bot\Tests\Traits;

use Illuminate\Support\Collection;
use Telegram\Bot\Commands\Command;

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

                return $mockCommand->reveal();
            });
    }
}
