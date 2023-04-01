<?php

namespace Telegram\Bot\Tests\Fixtures\Events;

class ListenerSpy
{
    public array $events = [];

    private ?object $calledWith = null;

    private int $timesCalled = 0;

    public function __invoke(object $event): void
    {
        $this->timesCalled++;
        $this->calledWith = $event;
        $this->events[$event->eventName()][] = $event;
    }

    public function numberOfTimeCalled(): int
    {
        return $this->timesCalled;
    }

    public function wasCalledWith(object $event): bool
    {
        return $event === $this->calledWith;
    }
}
