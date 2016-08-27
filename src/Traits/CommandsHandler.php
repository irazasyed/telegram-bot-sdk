<?php
namespace Telegram\Bot\Traits;

use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Objects\Update;

/**
 * CommandsHandler
 */
trait CommandsHandler
{
    /**
     * Return Command Bus.
     *
     * @return $this
     */
    protected function getCommandBus()
    {
        return CommandBus::Instance()->setTelegram($this);
    }

    /**
     * Processes Inbound Commands.
     *
     * @param bool $webhook
     *
     * @return Update|Update[]
     */
    public function commandsHandler($webhook = false)
    {
        if ($webhook) {
            $update = $this->getWebhookUpdate();
            $this->processCommand($update);

            return $update;
        }

        $updates = $this->getUpdates();
        $highestId = -1;

        foreach ($updates as $update) {
            $highestId = $update->updateId;
            $this->processCommand($update);
        }

        //An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id.
        if ($highestId != -1) {
            $params = [];
            $params['offset'] = $highestId + 1;
            $params['limit'] = 1;
            $this->markUpdateAsRead($params);
        }

        return $updates;
    }

    /**
     * Check update object for a command and process.
     *
     * @param Update $update
     */
    public function processCommand(Update $update)
    {
        $message = $update->message;

        if ($message !== null && $message->has('text')) {
            $this->getCommandBus()->handler($message->text, $update);
        }
    }

    /**
     * Helper to Trigger Commands.
     *
     * @param string $name   Command Name
     * @param Update $update Update Object
     *
     * @return mixed
     */
    public function triggerCommand($name, Update $update)
    {
        return $this->getCommandBus()->execute($name, $update->message->text, $update);
    }
}