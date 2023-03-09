<?php

namespace Telegram\Bot\Events;

use InvalidArgumentException;
use League\Event\EventDispatcherAwareBehavior;

/**
 * EmitsEvents.
 */
trait EmitsEvents
{
    use EventDispatcherAwareBehavior;

    /**
     * Emit an event.
     *
     * @param object|string $event
     * @return bool true if emitted, false otherwise.
     *
     * @throws InvalidArgumentException
     */
    protected function emitEvent($event): bool
    {
        $this->validateEvent($event);

        $this->eventDispatcher()->dispatch($event);

        return true;
    }

    /**
     * @param $event
     * @return void
     */
    private function validateEvent($event): void
    {
        if (is_string($event) || is_object($event)) {
            return;
        }

        throw new InvalidArgumentException('Event must be either be of type "string" or instance of object');
    }
}
