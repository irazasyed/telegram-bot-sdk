<?php

namespace Telegram\Bot\Traits;

use Psr\Http\Message\RequestInterface;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Objects\Update;

/**
 * CommandsHandler.
 */
trait CommandsHandler
{
    /**
     * Return Command Bus.
     *
     * @return CommandBus
     */
    protected function getCommandBus(): CommandBus
    {
        return CommandBus::Instance()->setTelegram($this);
    }

    /**
     * Get all registered commands.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->getCommandBus()->getCommands();
    }

    /**
     * Processes Inbound Commands.
     *
     * @param bool $webhook
     * @param RequestInterface|null $request
     * @return Update|Update[]
     */
    public function commandsHandler(bool $webhook = false, ?RequestInterface $request = null)
    {
        return $webhook ? $this->useWebHook($request) : $this->useGetUpdates();
    }

    /**
     * Process the update object for a command from your webhook.
     *
     * @param RequestInterface|null $request
     * @return Update
     */
    protected function useWebHook(?RequestInterface $request = null): Update
    {
        $update = $this->getWebhookUpdate(true, $request);
        $this->processCommand($update);

        return $update;
    }

    /**
     * Process the update object for a command using the getUpdates method.
     *
     * @return Update[]
     */
    protected function useGetUpdates(): array
    {
        $updates = $this->getUpdates();
        $highestId = -1;

        foreach ($updates as $update) {
            $highestId = $update->updateId;
            $this->processCommand($update);
        }

        //An update is considered confirmed as soon as getUpdates is called with an offset higher than it's update_id.
        if ($highestId != -1) {
            $this->markUpdateAsRead($highestId);
        }

        return $updates;
    }

    /**
     * Mark updates as read.
     *
     * @param $highestId
     *
     * @return Update[]
     */
    protected function markUpdateAsRead($highestId): array
    {
        $params = [];
        $params['offset'] = $highestId + 1;
        $params['limit'] = 1;

        return $this->getUpdates($params, false);
    }

    /**
     * Check update object for a command and process.
     *
     * @param Update $update
     */
    public function processCommand(Update $update)
    {
        $this->getCommandBus()->handler($update);
    }

    /**
     * @deprecated This method will be protected and signature will be changed in SDK v4.
     * Helper to Trigger Commands.
     *
     * @param string $name   Command Name
     * @param Update $update Update Object
     * @param array|null $entity
     *
     * @return mixed
     */
    public function triggerCommand(string $name, Update $update, $entity = null)
    {
        $entity = $entity ?? ['offset' => 0, 'length' => strlen($name) + 1, 'type' => "bot_command"];

        return $this->getCommandBus()->execute(
            $name,
            $update,
            $entity
        );
    }
}
