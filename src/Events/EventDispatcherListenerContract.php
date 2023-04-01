<?php

namespace Telegram\Bot\Events;

use Psr\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherListenerContract extends EventDispatcherInterface
{
    public function subscribeTo(string $event, callable $listener, int $priority = 0): void;
}
