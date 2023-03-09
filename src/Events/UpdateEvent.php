<?php

namespace Telegram\Bot\Events;

use League\Event\HasEventName;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

final class UpdateEvent implements HasEventName
{
    /**
     * @var string
     */
    public const NAME = 'update';

    /**
     * @deprecated Will be removed in SDK v4
     */
    private string $name;

    /** @var Api */
    public Api $telegram;

    /** @var Update */
    public Update $update;

    public function __construct(Api $telegram, Update $update, string $name = self::NAME)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->name = $name;
    }

    public function eventName(): string
    {
        return $this->name;
    }
}
