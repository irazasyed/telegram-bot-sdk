<?php

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class UpdateEvent extends AbstractEvent
{
    public const NAME = 'update';

    public Api $telegram;
    public Update $update;

    public function __construct(Api $telegram, Update $update)
    {
        $this->telegram = $telegram;
        $this->update = $update;
    }

    /**
     * @internal
     * @deprecated Will be removed in SDK v4
     */
    public function cloneWithCustomName(string $eventName): self
    {
        return new class ($this->telegram, $this->update, $eventName) extends UpdateEvent {
            /** @var string */
            private $eventName;

            public function __construct(Api $telegram, Update $update, string $eventName)
            {
                $this->eventName = $eventName;
                parent::__construct($telegram, $update);
            }

            /** @inheritDoc */
            public function getName(): string
            {
                return $this->eventName;
            }
        };
    }
}
