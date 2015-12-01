<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;

/**
 * Class CommandBus.
 */
class CommandBus
{
    /**
     * @var Command[] Holds all commands.
     */
    protected $commands = [];

    /**
     * @var Api
     */
    private $telegram;

    /**
     * Instantiate Command Bus.
     *
     * @param Api $telegram
     *
     * @throws TelegramSDKException
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Returns the list of commands.
     *
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Add a list of commands.
     *
     * @param array $commands
     *
     * @return CommandBus
     */
    public function addCommands(array $commands)
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
     * @throws TelegramSDKException
     *
     * @return CommandBus
     */
    public function addCommand($command)
    {
        if (!is_object($command)) {
            if (!class_exists($command)) {
                throw new TelegramSDKException(
                    sprintf(
                        'Command class "%s" not found! Please make sure the class exists.',
                        $command
                    )
                );
            }

            if ($this->telegram->hasContainer()) {
                $command = $this->buildDependencyInjectedCommand($command);
            } else {
                $command = new $command();
            }
        }

        if ($command instanceof CommandInterface) {

            /*
             * At this stage we definitely have a proper command to use.
             *
             * @var Command $command
             */
            $this->commands[$command->getName()] = $command;

            return $this;
        }

        throw new TelegramSDKException(
            sprintf(
                'Command class "%s" should be an instance of "Telegram\Bot\Commands\CommandInterface"',
                get_class($command)
            )
        );
    }

    /**
     * Remove a command from the list.
     *
     * @param $name
     *
     * @return CommandBus
     */
    public function removeCommand($name)
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
    public function removeCommands(array $names)
    {
        foreach ($names as $name) {
            $this->removeCommand($name);
        }

        return $this;
    }

    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     *
     * @param $message
     * @param $update
     *
     * @throws TelegramSDKException
     *
     * @return Update
     */
    public function handler($message, Update $update)
    {
        $match = $this->parseCommand($message);
        if (!empty($match)) {
            $command = $match[1];
//            $bot = (!empty($match[2])) ? $match[2] : '';
            $arguments = $match[3];
            $this->execute($command, $arguments, $update);
        }

        return $update;
    }

    /**
     * Parse a Command for a Match.
     *
     * @param $text
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function parseCommand($text)
    {
        if (trim($text) === '') {
            throw new \InvalidArgumentException('Message is empty, Cannot parse for command');
        }

        preg_match('/^\/([^\s@]+)@?(\S+)?\s?(.*)$/', $text, $matches);

        return $matches;
    }

    /**
     * Execute the command.
     *
     * @param $name
     * @param $arguments
     * @param $message
     *
     * @return mixed
     */
    public function execute($name, $arguments, $message)
    {
        if (array_key_exists($name, $this->commands)) {
            return $this->commands[$name]->make($this->telegram, $arguments, $message);
        } elseif (array_key_exists('help', $this->commands)) {
            return $this->commands['help']->make($this->telegram, $arguments, $message);
        }

        return 'Ok';
    }

    /**
     * Use PHP Reflection and Laravel Container to instantiate the command with type hinted dependencies.
     *
     * @param $commandClass
     *
     * @return object
     */
    private function buildDependencyInjectedCommand($commandClass)
    {

        // check if the command has a constructor
        if (!method_exists($commandClass, '__construct')) {
            return new $commandClass();
        }

        // get constructor params
        $constructorReflector = new \ReflectionMethod($commandClass, '__construct');
        $params = $constructorReflector->getParameters();

        // if no params are needed proceed with normal instantiation
        if (empty($params)) {
            return new $commandClass();
        }

        // otherwise fetch each dependency out of the container
        $container = $this->telegram->getContainer();
        $dependencies = [];
        foreach ($params as $param) {
            $dependencies[] = $container->make($param->getClass()->name);
        }

        // and instantiate the object with dependencies through ReflectionClass
        $classReflector = new \ReflectionClass($commandClass);

        return $classReflector->newInstanceArgs($dependencies);
    }
}
