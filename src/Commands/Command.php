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

    /** @var string Arguments passed to the command. */
    protected $arguments;

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
     * Get Arguments passed to the command.
     *
     * @return string
     */
    public function getArguments(): string
    {
        return $this->arguments;
    }

    /**
     * @inheritDoc
     */
    public function make(Api $telegram, Update $update)
    {
        $this->telegram = $telegram;
        $this->update = $update;

        $message = $update->getMessage();

        if ($message !== null && $message->has('text')) {
            $this->arguments = $message->text;
        }

        return $this->handle($this->arguments);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function handle($arguments);

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
