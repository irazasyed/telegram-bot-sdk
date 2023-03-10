<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
use Telegram\Bot\Answers\Answerable;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\MessageEntity;
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
     */
    protected string $name;

    /** @var string[] Command Aliases - Helpful when you want to trigger command with more than one name. */
    protected array $aliases = [];

    /** @var string The Telegram command description. */
    protected string $description;

    /** @var array Holds parsed command arguments */
    protected array $arguments = [];

    /** @var string Command Argument Pattern */
    protected string $pattern = '';

    /** @var array|null Details of the current entity this command is responding to - offset, length, type etc */
    protected ?array $entity;

    /**
     * @var string
     */
    private const OPTIONAL_BOT_NAME = '(?:@.+?bot)?\s+?';

    /**
     * Get the Command Name.
     *
     * The name of the Telegram command.
     * Ex: help - Whenever the user sends /help, this would be resolved.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Command Name.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Command Aliases.
     *
     * Helpful when you want to trigger command with more than one name.
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * Set Command Aliases.
     */
    public function setAliases(array|string $aliases): self
    {
        $this->aliases = is_array($aliases) ? $aliases : [$aliases];

        return $this;
    }

    /**
     * Get Command Description.
     *
     * The Telegram command description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set Command Description.
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Arguments Description.
     *
     * Get Command Arguments.
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Set Command Arguments.
     */
    public function setArguments(array $arguments): self
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Get Command Arguments Pattern.
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Get Command Arguments Pattern.
     */
    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Process Inbound Command.
     */
    public function make(Api $telegram, Update $update, array $entity): mixed
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->entity = $entity;
        $this->arguments = $this->parseCommandArguments();

        return $this->handle();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function handle();

    /**
     * Helper to Trigger other Commands.
     */
    protected function triggerCommand(string $command): mixed
    {
        return $this->getCommandBus()->execute($command, $this->update, $this->entity);
    }

    /**
     * Returns an instance of Command Bus.
     */
    public function getCommandBus(): CommandBus
    {
        return $this->telegram->getCommandBus();
    }

    /**
     * Parse Command Arguments.
     */
    protected function parseCommandArguments(): array
    {
        //Extract variable names from the supplied pattern
        $required = $this->extractVariableNames('/\{(\D\w+?)}/');
        $optional = $this->extractVariableNames('/\{(\D\w+?)\?}/');
        $customRegex = $this->checkForCustomRegex($required, $optional);

        //Generate the regex needed to search for this pattern
        $regex = $this->prepareRegex($required, $optional, $customRegex);
        preg_match($regex, $this->relevantMessageSubString(), $matches);

        return $this->formatMatches($matches, $required, $optional);
    }

    private function extractVariableNames(string $regex): Collection
    {
        preg_match_all($regex, $this->pattern, $matches);

        return collect($matches[1]);
    }

    private function prepareRegex(Collection $required, Collection $optional, string $customRegex): string
    {
        if ($customRegex !== '' && $customRegex !== '0') {
            $customRegex = sprintf('(?P<custom>%s)', $customRegex);
        }

        $requiredPattern = $required
            ->map(static fn ($varName): string => sprintf('(?P<%s>[^ ]++)', $varName))
            ->implode('\s+?');

        $optionalPattern = $optional
            ->map(static fn ($varName): string => sprintf('(?:\s+?(?P<%s>[^ ]++))?', $varName))
            ->implode('');

        if ($this->aliases === []) {
            $commandName = $this->name;
        } else {
            $names = array_merge([$this->name], $this->aliases);
            $commandName = '(?:'.implode('|', $names).')';
        }

        return sprintf('%%/%s%s%s%s%s%%si', $commandName, self::OPTIONAL_BOT_NAME, $requiredPattern, $optionalPattern, $customRegex);
    }

    private function formatMatches(array $matches, Collection $required, Collection $optional): array
    {
        return collect($matches)
            ->intersectByKeys(
                $required
                    ->merge($optional)
                    // incase this was a custom regex search we need to add a custom key
                    ->push('custom')
                    ->flip()
            )->all();
    }

    private function checkForCustomRegex(Collection $required, Collection $optional): string
    {
        if ($this->pattern === '') {
            return '';
        }

        if ($this->pattern === '0') {
            return '';
        }

        if (! $required->isEmpty()) {
            return '';
        }

        if (! $optional->isEmpty()) {
            return '';
        }

        return $this->pattern;
    }

    private function relevantMessageSubString(): bool|string
    {
        //Get all the bot_command offsets in the Update object
        $commandOffsets = $this->allCommandOffsets();

        if ($commandOffsets->isEmpty()) {
            return $this->getUpdate()->getMessage()->text;
        }

        //Extract the current offset for this command and, if it exists, the offset of the NEXT bot_command entity
        $splice = $commandOffsets->splice(
            $commandOffsets->search($this->entity['offset']),
            2
        );

        return $splice->count() === 2 ? $this->cutTextBetween($splice) : $this->cutTextFrom($splice);
    }

    private function cutTextBetween(Collection $splice): string
    {
        return substr(
            $this->getUpdate()->getMessage()->text,
            $splice->first(),
            $splice->last() - $splice->first()
        );
    }

    private function cutTextFrom(Collection $splice): string
    {
        return substr(
            $this->getUpdate()->getMessage()->text,
            $splice->first()
        );
    }

    private function allCommandOffsets(): Collection
    {
        $message = $this->getUpdate()
            ->getMessage();

        return $message->hasCommand() ?
            $message
                ->get('entities', collect())
                ->filter(static fn (MessageEntity $entity): bool => $entity->type === 'bot_command')
                ->pluck('offset') :
            collect();
    }
}
