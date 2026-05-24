<?php

namespace Telegram\Bot\Events;

use League\Event\EventDispatcher;

if (class_exists(EventDispatcher::class)) {
    interface HasEventName extends \League\Event\HasEventName {}
} else {
    interface HasEventName
    {
        public function eventName(): string;
    }
}
