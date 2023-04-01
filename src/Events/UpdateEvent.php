<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

final class UpdateEvent extends UpdateWasReceived
{
    /**
     * @var string
     */
    public const NAME = 'update';

    public function __construct(
        Api $telegram,
        Update $update,
        /**
         * @deprecated Will be removed in SDK v4
         */
        protected string $name = self::NAME
    ) {
        parent::__construct($telegram, $update);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
