<?php

namespace Telegram\Bot\Events;

class Emitter extends \League\Event\Emitter implements EventDispatcherListenerContract
{
    public function subscribeTo(string $event, callable $listener, int $priority = 0): void
    {
        $this->addListener($event, $listener, $priority);
    }

    public function dispatch(object $event): object
    {
        return $this->emit($event);
    }
}
