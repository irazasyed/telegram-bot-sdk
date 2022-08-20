<?php

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

final class UpdateEvent extends AbstractEvent
{
    public const NAME = 'update';

    /**
     * @deprecated Will be removed in SDK v4
     * @var string
     */
    private $name;

    /** @var \Telegram\Bot\Api */
    public $telegram;

    /** @var \Telegram\Bot\Objects\Update */
    public $update;

    public function __construct(Api $telegram, Update $update, string $name = self::NAME)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->name = $name;
    }

    /** @inheritDoc */
    public function getName(): string
    {
        return $this->name;
    }
}
