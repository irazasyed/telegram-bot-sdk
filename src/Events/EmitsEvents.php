<?php

namespace Telegram\Bot\Events;

use League\Event\Emitter;
use League\Event\EventInterface;

trait EmitsEvents
{
    /**
     * @var Emitter
     */
    private $eventEmitter;

    /**
     * @param EventInterface|string $event
     * @throws \InvalidArgumentException
     * @return bool true if emitted, false otherwise
     */
    private function emitEvent($event)
    {
        if (is_null($this->eventEmitter)) {
            return false;
        }

        if (!is_string($event) && !$event instanceof EventInterface) {
            throw new \InvalidArgumentException('Event must be either be of type "string" or instance of League\Event\EventInterface');
        }

        $this->eventEmitter->emit($event);

        return true;
    }

    /**
     * @param EventInterface[]|string[] $events
     * @throws \InvalidArgumentException
     * @return bool true if all emitted, false otherwise
     */
    private function emitBatchOfEvents(array $events)
    {
        if (is_null($this->eventEmitter)) {
            return false;
        }

        foreach ($events as $e) {
            if (!is_string($e) && !$e instanceof EventInterface) {
                throw new \InvalidArgumentException('Event must be either be of type "string" or instance of League\Event\EventInterface');
            }
        }

        $this->emitBatchOfEvents($events);

        return true;
    }

    /**
     * @return Emitter
     */
    public function getEventEmitter()
    {
        return $this->eventEmitter;
    }

    /**
     * @param Emitter $eventEmitter
     */
    public function setEventEmitter($eventEmitter)
    {
        $this->eventEmitter = $eventEmitter;
    }
}
