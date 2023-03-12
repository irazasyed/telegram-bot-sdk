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
     *
     * @return bool true if emitted, false otherwise.
     *
     * @throws InvalidArgumentException
     */
    protected function emitEvent(object|string $event): bool
    {
        $this->validateEvent($event);

        $this->eventDispatcher()->dispatch($event);

        return true;
    }

    private function validateEvent($event): void
    {
        if (is_string($event)) {
            return;
        }
        if (is_object($event)) {
            return;
        }
        throw new InvalidArgumentException('Event must be either be of type "string" or instance of object');
    }
}
