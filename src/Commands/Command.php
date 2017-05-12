<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Answers\Answerable;

/**
 * Class Command.
 */
abstract class Command implements CommandInterface
{
    use Answerable;

    /**
     * The name of the Telegram command.
     * Ex: help - Whenever the user sends /help, this would be resolved.
     *
     * @var string
     */
    protected $name;

    /** @var array Command Aliases - Helpful when you want to trigger command with more than one name. */
    protected $aliases = [];

    /** @var string The Telegram command description. */
    protected $description;

    /** @var int|null For multiple commands in an update, the current command number. */
    protected $entityNumber;

    /**
     * Get Command Name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Command Name.
     *
     * @param $name
     *
     * @return Command
     */
    public function setName($name): Command
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Command Aliases
     *
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * Get Command Description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set Command Description.
     *
     * @param $description
     *
     * @return Command
     */
    public function setDescription($description): Command
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function make(Api $telegram, Update $update, $entityNumber = null)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->entityNumber = $entityNumber;

        return $this->handle();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function handle();

    /**
     * Helper to Trigger other Commands.
     *
     * @param string $command
     *
     * @return mixed
     */
    protected function triggerCommand(string $command)
    {
        return $this->getCommandBus()->execute($command, $this->update);
    }

    /**
     * Returns an instance of Command Bus.
     *
     * @return CommandBus
     */
    public function getCommandBus(): CommandBus
    {
        return $this->telegram->getCommandBus();
    }
}
