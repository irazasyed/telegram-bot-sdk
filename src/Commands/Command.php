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

    /** @var string[] Command Aliases - Helpful when you want to trigger command with more than one name. */
    protected $aliases = [];

    /** @var string Command Argument Pattern */
    protected $pattern = '';

    /** @var string The Telegram command description. */
    protected $description;

    /** @var array Holds parsed command arguments */
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
    public function setName(string $name): Command
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Command Aliases.
     *
     * @return string[]
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * Set Command Aliases.
     *
     * @param $aliases
     *
     * @return Command
     */
    public function setAliases($aliases): Command
    {
        $this->aliases = $aliases;

        return $this;
    }

    /**
     * Get Command Arguments Pattern.
     *
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Get Command Arguments Pattern.
     *
     * @param string $pattern
     *
     * @return Command
     */
    public function setPattern(string $pattern): Command
    {
        $this->pattern = $pattern;

        return $this;
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
    public function setDescription(string $description): Command
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Command Arguments.
     *
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Set Command Arguments.
     *
     * @param array $arguments
     *
     * @return Command
     */
    public function setArguments(array $arguments): Command
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function make(Api $telegram, Update $update)
    {
        $this->telegram = $telegram;
        $this->update = $update;

        return call_user_func_array([$this, 'handle'], $this->getArguments());
    }

    /**
     * {@inheritdoc}
     */
//    abstract public function handle(...$args);

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
