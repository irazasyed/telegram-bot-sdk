<?php

namespace Telegram\Bot\Commands;

use Telegram\Bot\Answers\AnswerBus;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\Singleton;

/**
 * Class CommandBus.
 */
class CommandBus extends AnswerBus
{
    use Singleton;

    /**
     * @var Command[] Holds all commands.
     */
    protected $commands = [];

    /**
     * @var Command[] Holds all commands' aliases.
     */
    protected $commandAliases = [];

    /**
     * Instantiate Command Bus.
     *
     * @param Api|null $telegram
     *
     * @throws TelegramSDKException
     */
    public function __construct(Api $telegram = null)
    {
        $this->telegram = $telegram;
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
     */
    public function addCommands(array $commands): CommandBus
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
    public function addCommand($command): CommandBus
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
                $command = $this->buildDependencyInjectedAnswer($command);
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

            $aliases = $command->getAliases();

            if (empty($aliases)) {
                return $this;
            }

            foreach ($command->getAliases() as $alias) {
                if (isset($this->commands[$alias])) {
                    throw new TelegramSDKException(sprintf(
                        '[Error] Alias [%s] conflicts with command name of "%s" try with another name or remove this alias from the list.',
                        $alias,
                        get_class($command)
                    ));
                }

                if (isset($this->commandAliases[$alias])) {
                    throw new TelegramSDKException(sprintf(
                        '[Error] Alias [%s] conflicts with another command\'s alias list: "%s", try with another name or remove this alias from the list.',
                        $alias,
                        get_class($command)
                    ));
                }

                $this->commandAliases[$alias] = $command;
            }

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
    public function removeCommand($name): CommandBus
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
    public function removeCommands(array $names): CommandBus
    {
        foreach ($names as $name) {
            $this->removeCommand($name);
        }

        return $this;
    }

    /**
     * Parse a Command for a Match.
     *
     * @param $text
     *
     * @param $offset
     * @param $length
     *
     * @return string
     */
    public function parseCommand($text, $offset, $length): string
    {
        if (trim($text) === '') {
            throw new \InvalidArgumentException('Message is empty, Cannot parse for command');
        }

        return substr(
            $text,
            $offset + 1,
            $length - 1
        );
    }

    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     *
     * @param $update
     *
     * @throws TelegramSDKException
     *
     * @return Update
     */
    protected function handler(Update $update): Update
    {
        $message = $update->getMessage();

        if ($message === null) {
            return $update;
        } elseif ($message !== null && $message->has('text') && $message->has('entities')) {
            foreach ($message->entities as $entity) {
                if ($entity['type'] === 'bot_command') {
                    $command = $this->parseCommand(
                        $message->text,
                        $entity['offset'],
                        $entity['length']
                    );


                    $this->execute($command, $update);
                }
            }
        }

        return $update;
    }

    /**
     * Execute the command.
     *
     * @param $name
     * @param $update
     *
     * @return mixed
     */
    protected function execute(string $name, Update $update)
    {
        if (isset($this->commands[$name])) {
            return $this->commands[$name]->make($this->telegram, $update);
        } elseif (isset($this->commandAliases[$name])) {
            return $this->commandAliases[$name]->make($this->telegram, $update);
        } elseif (isset($this->commands['help'])) {
            return $this->commands['help']->make($this->telegram, $update);
        }

        return 'Ok';
    }
}
