<?php

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

final class UpdateEvent extends AbstractEvent
{
    public const NAME = 'update';

    /** @var \Telegram\Bot\Api */
    public $telegram;

    /** @var \Telegram\Bot\Objects\Update */
    public $update;

    /**
     * @deprecated Will be removed in SDK v4
     * @var string|null
     */
    private $eventName = null;

    public function __construct(Api $telegram, Update $update)
    {
        $this->telegram = $telegram;
        $this->update = $update;
    }

    /** @inheritDoc */
    public function getName()
    {
        return $this->eventName ?: get_class($this);
    }

    /**
     * @internal
     * @deprecated Will be removed in SDK v4
     */
    public function cloneWithCustomName(string $eventName): UpdateEvent
    {
        $event = new self($this->telegram, $this->update);
        $event->eventName = $eventName;

        return $event;
    }
}
