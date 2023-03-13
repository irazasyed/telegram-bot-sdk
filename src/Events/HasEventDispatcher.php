<?php

namespace Telegram\Bot\Events;

use League\Event\EventDispatcherAwareBehavior;

trait HasEventDispatcher
{
    use EventDispatcherAwareBehavior;

    public function hasEventDispatcher(): bool
    {
        return $this->eventDispatcher() !== null;
    }
}
