<?php

namespace Telegram\Bot;

use Illuminate\Support\Arr;
use Psr\Container\ContainerInterface;
use Telegram\Bot\Commands\CommandInterface;
use Telegram\Bot\Exceptions\TelegramBotNotFoundException;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class BotsManager.
 *
 * @mixin Api
 */
final class BotsManager
{
    private ?ContainerInterface $container = null;

    /** @var array<string, Api> The active bot instances. */
    private array $bots = [];

    /**
     * TelegramManager constructor.
     */
    public function __construct(private array $config)
    {
    }

    /**
     * Set the IoC Container.
     *
     * @param  ContainerInterface  $container  Container instance
     */
    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the configuration for a bot.
     *
     *
     * @throws TelegramBotNotFoundException
     */
    public function getBotConfig(?string $name = null): array
    {
        $name ??= $this->getDefaultBotName();

        $bots = collect($this->getConfig('bots'));

        $config = $bots->get($name);

        if (! $config) {
            throw TelegramBotNotFoundException::create($name);
        }

        return $config + ['bot' => $name];
    }

    /**
     * Get a bot instance.
     *
     *
     * @throws TelegramSDKException
     */
    public function bot(?string $name = null): Api
    {
        $name ??= $this->getDefaultBotName();

        if (! isset($this->bots[$name])) {
            $this->bots[$name] = $this->makeBot($name);
        }

        return $this->bots[$name];
    }

    /**
     * Reconnect to the given bot.
     *
     *
     * @throws TelegramSDKException
     */
    public function reconnect(?string $name = null): Api
    {
        $name ??= $this->getDefaultBotName();
        $this->disconnect($name);

        return $this->bot($name);
    }

    /**
     * Disconnect from the given bot.
     */
    public function disconnect(?string $name = null): self
    {
        $name ??= $this->getDefaultBotName();
        unset($this->bots[$name]);

        return $this;
    }

    /**
     * Determine if given bot name exists.
     */
    public function hasBot(string $name): bool
    {
        return isset($this->bots[$name]);
    }

    /**
     * Get the specified configuration value for Telegram.
     */
    public function getConfig(string $key, mixed $default = null): mixed
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Get the default bot name.
     */
    public function getDefaultBotName(): ?string
    {
        return $this->getConfig('default');
    }

    /**
     * Set the default bot name.
     */
    public function setDefaultBot(string $name): self
    {
        Arr::set($this->config, 'default', $name);

        return $this;
    }

    /**
     * Return all the created bots.
     *
     * @return array<string, Api>
     */
    public function getBots(): array
    {
        return $this->bots;
    }

    /**
     * Make the bot instance.
     *
     *
     * @throws TelegramSDKException
     */
    protected function makeBot(string $name): Api
    {
        $config = $this->getBotConfig($name);

        $token = data_get($config, 'token');

        $telegram = new Api(
            $token,
            $this->getConfig('async_requests', false),
            $this->getConfig('http_client_handler', null),
            $this->getConfig('base_bot_url', null)
        );

        // Check if DI needs to be enabled for Commands
        if ($this->container instanceof ContainerInterface && $this->getConfig('resolve_command_dependencies', false)) {
            $telegram::setContainer($this->container);
        }

        $commands = data_get($config, 'commands', []);
        $commands = $this->parseBotCommands($commands);

        // Register Commands
        $telegram->addCommands($commands);

        return $telegram;
    }

    /**
     * @param  list<(string | class-string<CommandInterface>)>  $commands  A list of command names or FQCNs of CommandInterface instances.
     * @return array An array of commands which includes global and bot specific commands.
     *
     * @deprecated Will be removed in SDK v4
     *
     * @internal
     * Builds the list of commands for the given commands array.
     */
    public function parseBotCommands(array $commands): array
    {
        $globalCommands = $this->getConfig('commands', []);
        $parsedCommands = $this->parseCommands($commands);

        return collect($globalCommands)
            ->merge($parsedCommands)
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Parse an array of commands and build a list.
     *
     * @param  list<(string | class-string<CommandInterface>)>  $commands
     */
    private function parseCommands(array $commands): array
    {
        $commandGroups = collect($this->getConfig('command_groups'));
        $sharedCommands = collect($this->getConfig('shared_commands'));

        return collect($commands)->map(function ($command) use ($commandGroups, $sharedCommands): mixed {
            // If the command is a group, we'll parse through the group of commands
            // and resolve the full class name.
            if ($commandGroups->has($command)) {
                return $this->parseCommands($commandGroups->get($command));
            }

            // If this command is actually a shared command, we'll extract the full
            // class name out of the command list now.
            if ($sharedCommands->has($command)) {
                return $sharedCommands->get($command);
            }

            return $command;
        })
            ->flatten()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Magically pass methods to the default bot.
     *
     * @return mixed
     *
     * @throws TelegramSDKException
     */
    public function __call(string $method, array $parameters)
    {
        return $this->bot()->$method(...$parameters);
    }
}
