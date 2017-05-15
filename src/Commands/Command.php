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

    /** @var string The Telegram command description. */
    protected $description;

    /** @var array Holds parsed command arguments */
    protected $arguments = [];

    /** @var string Command Argument Pattern */
    protected $pattern = '';

    /** @var array|null Details of the current entity this command is responding to - offset, length, type etc */
    protected $entity;

    /**
     * Get the Command Name.
     *
     * The name of the Telegram command.
     * Ex: help - Whenever the user sends /help, this would be resolved.
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
     * Get Command Aliases
     *
     * Helpful when you want to trigger command with more than one name.
     *
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * Set Command Aliases.
     *
     * @param string|array $aliases
     *
     * @return Command
     */
    public function setAliases($aliases): Command
    {
        $this->aliases = is_array($aliases) ? $aliases : [$aliases];

        return $this;
    }

    /**
     * Get Command Description.
     *
     * The Telegram command description.
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
     * Get Arguments Description.
     *
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
     * Process Inbound Command.
     *
     * @param Api    $telegram
     * @param Update $update
     * @param array  $entity
     *
     * @return mixed
     */
    public function make(Api $telegram, Update $update, array $entity)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->entity = $entity;
        $this->arguments = $this->parseCommandArguments();

        return call_user_func_array([$this, 'handle'], $this->getArguments());
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

    /**
     * Parse Command Arguments.
     *
     * @return array
     */
    protected function parseCommandArguments(): array
    {
        $args = [];
        $patterns = ['/\/([\w]+)/', '/\{((?:(?!\d+,?\d+?)\w)+?)\}/'];

        $pattern = sprintf('/%s %s', $this->getName(), $this->getPattern());
        $pattern = str_replace(['/', ' '], ['\/', '\s?'], $pattern);

        $regex = '/' . preg_replace($patterns, ['/(${1})', '([\w]+)?'], $pattern) . '/iu';

        if (preg_match($regex, $this->getUpdate()->getMessage()->text, $matches, 0, $this->entity['offset'])) {
            $args = array_slice($matches, 2);
        }

        preg_match_all($patterns[1], $pattern, $matches);

        $params = $matches[1];

        if (count($args) > count($params)) {
            $args = array_slice($args, 0, count($params));
        } elseif (count($args) < count($params)) {
            $args = array_pad($args, count($params), '');
        }

        return array_combine($params, $args);
    }
}
