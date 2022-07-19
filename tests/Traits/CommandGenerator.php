<?php

namespace Telegram\Bot\Tests\Traits;

use Illuminate\Support\Collection;
use Telegram\Bot\Commands\Command;

trait CommandGenerator
{
    /**
     * @param int $numberRequired
     *
     * @return Collection
     */
    private function commandGenerator($numberRequired)
    {
        $range = range(1, $numberRequired, 1);

        return collect($range)
            ->map(function (int $instanceNumber) {
                return new class($instanceNumber) extends Command {
                    private $instanceNumber;

                    public function __construct(int $instanceNumber)
                    {
                        $this->instanceNumber = $instanceNumber;
                    }

                    public function getName(): string
                    {
                        return "MockCommand$this->instanceNumber";
                    }

                    public function getAliases(): array
                    {
                        return ["MockAlias$this->instanceNumber"];
                    }

                    public function handle()
                    {
                    }
                };
            });
    }
}
