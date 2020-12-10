<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Collection;
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
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Command Aliases.
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
    public function setAliases($aliases): self
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
    public function setDescription(string $description): self
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
    public function setArguments(array $arguments): self
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
    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Process Inbound Command.
     *
     * @param Api $telegram
     * @param Update $update
     * @param array $entity
     *
     * @return mixed
     */
    public function make(Api $telegram, Update $update, array $entity)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->entity = $entity;
        $this->arguments = $this->parseCommandArguments();

        return call_user_func_array([$this, 'handle'], array_values($this->getArguments()));
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
        return $this->getCommandBus()->execute($command, $this->update, $this->entity);
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
        //Extract variable names from the supplied pattern
        $required = $this->extractVariableNames('/\{([^\d]\w+?)\}/');
        $optional = $this->extractVariableNames('/\{([^\d]\w+?)\?\}/');
        $customRegex = $this->checkForCustomRegex($required, $optional);

        //Generate the regex needed to search for this pattern
        $regex = $this->prepareRegex($required, $optional, $customRegex);
        preg_match($regex, $this->relevantMessageSubString(), $matches);

        return $this->formatMatches($matches, $required, $optional);
    }

    /**
     * @param $regex
     *
     * @return Collection
     */
    private function extractVariableNames($regex)
    {
        preg_match_all($regex, $this->pattern, $matches);

        return collect($matches[1]);
    }

    /**
     * @param Collection $required
     * @param Collection $optional
     *
     * @param string $customRegex
     *
     * @return string
     */
    private function prepareRegex(Collection $required, Collection $optional, $customRegex)
    {
        $optionalBotName = '(?:@.+?bot)?\s+?';

        if ($customRegex) {
            $customRegex = "(?P<custom>$customRegex)";
        }

        $required = $required
            ->map(function ($varName) {
                return "(?P<$varName>[^ ]++)";
            })
            ->implode('\s+?');

        $optional = $optional
            ->map(function ($varName) {
                return "(?:\s+?(?P<$varName>[^ ]++))?";
            })
            ->implode('');

        return "%/{$this->getName()}{$optionalBotName}{$required}{$optional}{$customRegex}%si";
    }

    private function formatMatches(array $matches, Collection $required, Collection $optional)
    {
        return collect($matches)
            ->intersectByKeys(
                $required
                    ->merge($optional)
                    //incase this was a custom regex search we need to add a custom key
                    ->push('custom')
                    ->flip()
            )->all();
    }

    private function checkForCustomRegex(Collection $required, Collection $optional)
    {
        if ($this->pattern && $required->isEmpty() && $optional->isEmpty()) {
            return $this->pattern;
        }

        return '';
    }

    /**
     * @return bool|string
     */
    private function relevantMessageSubString()
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

    private function cutTextBetween(Collection $splice)
    {
        return substr(
            $this->getUpdate()->getMessage()->text,
            $splice->first(),
            $splice->last() - $splice->first()
        );
    }

    private function cutTextFrom(Collection $splice)
    {
        return substr(
            $this->getUpdate()->getMessage()->text,
            $splice->first()
        );
    }

    /**
     * @return Collection
     */
    private function allCommandOffsets()
    {
        $message = $this->getUpdate()
            ->getMessage();

        return !$message->hasCommand() ?
            collect() :
            $message
                ->get('entities', collect())
                ->filter(function ($entity) {
                    return $entity['type'] === 'bot_command';
                })
                ->pluck('offset');
    }
}
