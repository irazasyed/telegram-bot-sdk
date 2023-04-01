<?php

namespace Telegram\Bot\Events;

if (class_exists(\League\Event\AbstractEvent::class)) {
    abstract class AbstractEvent extends \League\Event\AbstractEvent implements HasEventName
    {
        public function eventName(): string
        {
            return $this->getName();
        }
    }
} else {
    abstract class AbstractEvent
    {
    }
}
