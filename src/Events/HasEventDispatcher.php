<?php

namespace Telegram\Bot\Events;

trait HasEventDispatcher
{
    /**
     * @var EventDispatcherListenerContract|null
     */
    protected $dispatcher;

    public function useEventDispatcher(EventDispatcherListenerContract $emitter): void
    {
        $this->dispatcher = $emitter;
    }

    public function eventDispatcher(): EventDispatcherListenerContract
    {
        if ($this->dispatcher === null) {
            $this->dispatcher = EventDispatcherFactory::create();
        }

        return $this->dispatcher;
    }

    public function hasEventDispatcher(): bool
    {
        return $this->eventDispatcher() !== null;
    }

    public function on(string $event, callable $listener, int $priority = 0): void
    {
        $this->eventDispatcher()->subscribeTo($event, $listener, $priority);
    }
}
