<?php

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\Objects\Update;

class UpdateWasReceivedEvent extends AbstractEvent
{
    /**
     * @var Update
     */
    private $update;

    /**
     * UpdateWasReceivedEvent constructor.
     * @param Update $update
     */
    public function __construct(Update $update)
    {
        $this->update = $update;
    }

    /**
     * @return Update
     */
    public function getUpdate()
    {
        return $this->update;
    }
}
