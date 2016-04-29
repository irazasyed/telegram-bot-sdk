<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Answers\Answerable;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

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

    /**
     * Command Aliases
     * Helpful when you want to trigger command with more than one name.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * @var string The Telegram command description.
     */
    protected $description;

    /**
     * @var string Arguments passed to the command.
     */
    protected $arguments;

    /**
     * Get Command Name.
     *
     * @return string
     */
    public function getName()
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
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Command Aliases
     *
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Get Command Description.
     *
     * @return string
     */
    public function getDescription()
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
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Arguments passed to the command.
     *
     * @return string
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @inheritDoc
     */
    public function make(Api $telegram, $arguments, Update $update)
    {
        $this->telegram = $telegram;
        $this->arguments = $arguments;
        $this->update = $update;

        return $this->handle($arguments);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function handle($arguments);

    /**
     * Helper to Trigger other Commands.
     *
     * @param      $command
     * @param null $arguments
     *
     * @return mixed
     */
    protected function triggerCommand($command, $arguments = null)
    {
        return $this->getCommandBus()->execute($command, $arguments ?: $this->arguments, $this->update);
    }

    /**
     * Returns an instance of Command Bus.
     *
     * @return CommandBus
     */
    public function getCommandBus()
    {
        return $this->telegram->getCommandBus();
    }
}
