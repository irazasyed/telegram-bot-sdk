<?php

namespace Telegram\Bot\Events;

use League\Event\Emitter;
use League\Event\EventInterface;

/**
 * EmitsEvents.
 */
trait EmitsEvents
{
    /** @var Emitter */
    protected $eventEmitter;

    /**
     * Emit an event.
     *
     * @param EventInterface|string $event
     *
     * @throws \InvalidArgumentException
     *
     * @return bool true if emitted, false otherwise.
     */
    protected function emitEvent($event): bool
    {
        if (is_null($this->eventEmitter)) {
            return false;
        }

        $this->validateEvent($event);

        $this->eventEmitter->emit($event);

        return true;
    }

    /**
     * Emit events in batch.
     *
     * @param EventInterface[]|string[] $events
     *
     * @throws \InvalidArgumentException
     *
     * @return bool true if all emitted, false otherwise
     */
    private function emitBatchOfEvents(array $events): bool
    {
        if (is_null($this->eventEmitter)) {
            return false;
        }

        foreach ($events as $e) {
            $this->validateEvent($e);
        }

        $this->emitBatchOfEvents($events);

        return true;
    }

    /**
     * Returns an event emitter.
     *
     * @return Emitter
     */
    public function getEventEmitter(): Emitter
    {
        return $this->eventEmitter;
    }

    /**
     * Set an event emitter.
     *
     * @param Emitter $eventEmitter
     *
     * @return $this
     */
    public function setEventEmitter($eventEmitter)
    {
        $this->eventEmitter = $eventEmitter;

        return $this;
    }

    /**
     * @param $event
     */
    private function validateEvent($event)
    {
        if (! is_string($event) && ! $event instanceof EventInterface) {
            throw new \InvalidArgumentException('Event must be either be of type "string" or instance of League\Event\EventInterface');
        }
    }
}
