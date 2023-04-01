<?php

namespace Telegram\Bot\Events;

use League\Event\EventDispatcher;
use League\Event\PrioritizedListenerRegistry;

class EventDispatcherFactory
{
    public static function create(): EventDispatcherListenerContract
    {
        if (class_exists(EventDispatcher::class)) {
            return new LeagueEventDispatcher(new PrioritizedListenerRegistry());
        }

        return new Emitter();
    }
}
