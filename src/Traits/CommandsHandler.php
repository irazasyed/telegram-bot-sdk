<?php

namespace Telegram\Bot\Traits;

use Psr\Http\Message\RequestInterface;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;

/**
 * CommandsHandler.
 */
trait CommandsHandler
{
    /**
     * Return Command Bus.
     */
    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }

    public function setCommandBus(CommandBus $commandBus): static
    {
        $this->commandBus = $commandBus;

        return $this;
    }

    /**
     * Processes Inbound Commands.
     *
     * @return Update|Update[]
     */
    public function commandsHandler(bool $webhook = false, ?RequestInterface $request = null): Update|array
    {
        return $webhook ? $this->useWebHook($request) : $this->useGetUpdates();
    }

    /**
     * Process the update object for a command from your webhook.
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
     *
     * @throws TelegramSDKException
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
        if ($highestId !== -1) {
            $this->markUpdateAsRead($highestId);
        }

        return $updates;
    }

    /**
     * Mark updates as read.
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
     */
    public function processCommand(Update $update): void
    {
        $this->commandBus->handler($update);
    }

    /**
     * @param  string  $name Command Name
     * @param  Update  $update Update Object
     *
     * @deprecated This method will be protected and signature will be changed in SDK v4.
     * Helper to Trigger Commands.
     */
    public function triggerCommand(string $name, Update $update, array $entity = null): mixed
    {
        $entity ??= ['offset' => 0, 'length' => strlen($name) + 1, 'type' => 'bot_command'];

        return $this->commandBus->execute(
            $name,
            $update,
            $entity
        );
    }
}
