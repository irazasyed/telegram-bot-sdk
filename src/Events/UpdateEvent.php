<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

final class UpdateEvent extends AbstractEvent implements HasEventName
{
    /**
     * @var string
     */
    public const NAME = 'update';

    public function __construct(
        public Api $telegram,
        public Update $update,
        /**
         * @deprecated Will be removed in SDK v4
         */
        protected string $name = self::NAME
    ) {}

    public function eventName(): string
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
