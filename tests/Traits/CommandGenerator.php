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
     * @param $numberRequired
     *
     * @return Collection
     */
    private function commandGenerator($numberRequired)
    {
        $range = range(1, $numberRequired, 1);

        return collect($range)
            ->map(function ($int) {
                $mockCommand = $this->prophesize(Command::class);
                $mockCommand->getName()->willReturn("MockCommand$int");
                $mockCommand->getAliases()->willReturn(["MockAlias$int"]);
                $mockCommand->getArguments()->willReturn([]);
                $mockCommand->make(Argument::type(Api::class), Argument::type(Update::class))->willReturn(null);

                return $mockCommand->reveal();
            });
    }
}
