<?php

namespace Telegram\Bot\Commands;

use Closure;
use Telegram\Bot\Answers\AnswerBus;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;

/**
 * Class CommandBus.
 */
class CommandBus extends AnswerBus
{
    /** @var Command[] Holds all commands. */
    protected $commands = [];

    /** @var Command[] Holds all commands' aliases. */
    protected $commandAliases = [];

    /** @var array|CommandsProcessor[] Processors that match messages with commands */
    private $commandProcessors;

    /**
     * Instantiate Command Bus.
     *
     * @param Api|null $telegram
     * @param CommandsProcessor[]|array $commandProcessors
     */
    public function __construct(array $commandProcessors, Api $telegram = null)
    {
        $this->telegram = $telegram;
        $this->commandProcessors = $commandProcessors;
    }

    /**
     * Returns the list of commands.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Add a list of commands.
     *
     * @param array $commands
     *
     * @return CommandBus
     * @throws TelegramSDKException
     */
    public function addCommands(array $commands): self
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }

        return $this;
    }

    /**
     * Add a command to the commands list.
     *
     * @param CommandInterface|string $command Either an object or full path to the command class.
     *
     * @return CommandBus
     * @throws TelegramSDKException
     *
     */
    public function addCommand($command): self
    {
        $command = $this->resolveCommand($command);

        /**
         * At this stage we definitely have a proper command to use.
         * @var Command $command
         */
        $this->commands[$command->getName()] = $command;

        $aliases = $command->getAliases();

        if (empty($aliases)) {
            return $this;
        }

        foreach ($command->getAliases() as $alias) {
            $this->checkForConflicts($command, $alias);

            $this->commandAliases[$alias] = $command;
        }

        return $this;
    }

    /**
     * Remove a command from the list.
     *
     * @param string $name
     * @return CommandBus
     */
    public function removeCommand(string $name): self
    {
        unset($this->commands[$name]);

        return $this;
    }

    /**
     * Removes a list of commands.
     *
     * @param array $names
     *
     * @return CommandBus
     */
    public function removeCommands(array $names): self
    {
        foreach ($names as $name) {
            $this->removeCommand($name);
        }

        return $this;
    }

    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     *
     * @param Update $update
     *
     * @return Update
     */
    public function handler(Update $update): Update
    {
        foreach ($this->commandProcessors as $processor) {
            $foundCommands = $processor->handle($update);

            foreach ($foundCommands as $command => $entity) {
                if ($entity instanceof Closure) {
                    $command = $entity;
                    $entity = [];
                }

                // Stop handling commands when executed return "true"
                if ($this->execute($command, $update, $entity) === true) {
                    return $update;
                }
            }
        }

        return $update;
    }

    /**
     * Execute the command.
     *
     * @param string|Closure $name
     * @param Update $update
     * @param array $entity
     *
     * @return bool If executed command return True - it means we need to stop executing other found commands
     */
    protected function execute($name, Update $update, array $entity)
    {
        if ($name instanceof Closure) {
            return $name($this->telegram, $update, $entity);
        }

        $command = $this->commands[$name] ??
            $this->commandAliases[$name] ??
            collect($this->commands)->filter(function ($command) use ($name) {
                return $command instanceof $name;
            })->first() ?? null;

        if ($command) {
            return $command->make($this->telegram, $update, $entity);
        }

        return false;
    }

    /**
     * @param $command
     *
     * @return object
     * @throws TelegramSDKException
     */
    private function resolveCommand($command)
    {
        $command = $this->makeCommandObj($command);

        if (!($command instanceof CommandInterface)) {
            throw new TelegramSDKException(
                sprintf(
                    'Command class "%s" should be an instance of "Telegram\Bot\Commands\CommandInterface"',
                    get_class($command)
                )
            );
        }

        return $command;
    }

    /**
     * @param $command
     * @param $alias
     *
     * @throws TelegramSDKException
     */
    private function checkForConflicts($command, $alias)
    {
        if (isset($this->commands[$alias])) {
            throw new TelegramSDKException(
                sprintf(
                    '[Error] Alias [%s] conflicts with command name of "%s" try with another name or remove this alias from the list.',
                    $alias, get_class($command)
                )
            );
        }

        if (isset($this->commandAliases[$alias])) {
            throw new TelegramSDKException(
                sprintf(
                    '[Error] Alias [%s] conflicts with another command\'s alias list: "%s", try with another name or remove this alias from the list.',
                    $alias,
                    get_class($command)
                )
            );
        }
    }

    /**
     * @param $command
     *
     * @return object
     * @throws TelegramSDKException
     */
    private function makeCommandObj($command)
    {
        if (is_object($command)) {
            return $command;
        }
        if (!class_exists($command)) {
            throw new TelegramSDKException(
                sprintf(
                    'Command class "%s" not found! Please make sure the class exists.',
                    $command
                )
            );
        }

        if ($this->telegram->hasContainer()) {
            return $this->buildDependencyInjectedAnswer($command);
        }

        return new $command();
    }
}
