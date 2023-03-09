<?php

namespace Telegram\Bot\Tests\Traits;

use Illuminate\Support\Collection;
use Telegram\Bot\Commands\Command;

trait CommandGenerator
{
    /**
     * @param  int  $numberRequired
     * @return Collection
     */
    private function commandGenerator($numberRequired): Collection
    {
        $range = range(1, $numberRequired, 1);

        return collect($range)
            ->map(fn(int $instanceNumber): Command => new class($instanceNumber) extends Command
            {
                private int $instanceNumber;

                public function __construct(int $instanceNumber)
                {
                    $this->instanceNumber = $instanceNumber;
                }

                public function getName(): string
                {
                    return sprintf('MockCommand%s', $this->instanceNumber);
                }

                public function getAliases(): array
                {
                    return [sprintf('MockAlias%s', $this->instanceNumber)];
                }

                public function handle(): void
                {
                }
            });
    }
}
