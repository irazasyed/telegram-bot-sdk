<?php

namespace Irazasyed\Telegram\Commands;

use Irazasyed\Telegram\Telegram;
use Irazasyed\Telegram\Commands\HelpCommand;
use Irazasyed\Telegram\Commands\CommandInterface;
use Irazasyed\Telegram\Exceptions\TelegramSDKException;

/**
 * Class CommandBus
 *
 * @package Irazasyed\Telegram\Commands
 */
class CommandBus
{
    /**
     * @var \Irazasyed\Telegram\Telegram
     */
    private $telegram;

    /**
     * @var array Holds all commands.
     */
    protected $commands = [];

    /**
     * Instantiate Command Bus
     *
     * @param \Irazasyed\Telegram\Telegram $telegram
     *
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function __construct(Telegram $telegram)
    {
        $this->telegram = $telegram;
//        $this->addCommand(new HelpCommand());
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
     * @return $this
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
     * @return $this
     *
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function addCommand($command)
    {
        if (!is_object($command)) {
            if (!class_exists($command)) {
                throw new TelegramSDKException(sprintf('Command class "%s" not found! Please make sure the class exists.',
                    $command));
            }

            $command = new $command();
        }

        if ($command instanceof CommandInterface) {
            $this->commands[$command->getName()] = $command;

            return $this;
        }

        throw new TelegramSDKException(sprintf('Command class "%s" should be an instance of "Irazasyed\Telegram\Commands\CommandInterface"',
            get_class($command)));
    }

    /**
     * Remove a command from the list.
     *
     * @param $name
     */
    public function removeCommand($name)
    {
        unset($this->commands[$name]);
    }

    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     *
     * @param $message
     * @param $update
     *
     * @return mixed
     *
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function handler($message, $update)
    {
        if ($match = $this->parseCommand($message)) {
            $command = $match[1];
            $bot = (!empty($match[2])) ? $match[2] : '';
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
     * @return array
     *
     * @throws \Irazasyed\Telegram\Commands\InvalidArgumentException
     */
    public function parseCommand($text)
    {
        if (trim($text) === '') {
            throw new InvalidArgumentException('Message is empty, Cannot parse for command');
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
     *
     * @throws \Irazasyed\Telegram\Exceptions\TelegramSDKException
     */
    public function execute($name, $arguments, $message)
    {
        if (array_key_exists($name, $this->commands)) {
            return $this->commands[$name]->make($this->telegram, $arguments, $message);
        }

        return $this->commands['help']->make($this->telegram, $arguments, $message);
    }
}
