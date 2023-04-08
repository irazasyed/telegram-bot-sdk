<?php

namespace Telegram\Bot\Commands;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;
use Illuminate\Support\Facades\Cache;

/**
 * TODO - custom cache system, for changes driver and set configs.
 * TODO - set time expire for cache.
 * */
abstract class CommandStepByStep extends Command
{

    /**
     * state for save nextSteps in cache, or not
     * */
    protected bool $shouldCacheNextStep = true;

    /**
     * private properties
     * */
    private $chat_id;
    private bool $hasAccess = true;

    /**
     * array of class commands which are the next step for a command
     *
     * @return string[]
     * */
    abstract function nextSteps(): array;

    /**
     * action for the prevoius command, if current command isn't previous command next step.
     *
     * @param $chat_id
     * @param Update $update
     * */
    abstract function failStepAction($chat_id, Update $update);

    /**
     * set value for shouldCacheNextStep
     *
     * @param bool $value
     * */
    abstract function setShouldCacheNextStep(bool $value): void;

    /**
     * this method will execute before check validation of nextStep.
     * if you want to clear cache or anything, you can use this method.
     * otherwise, let it be empty
     * */
    abstract public function actionBeforeMake();

    /**
     * check validation for next step
     * */
    private function nextStepValidation(Update $update): bool
    {
        // get from cache
        $previousCommand = Cache::get($this->chat_id);

        // if previous command hasn't next step, just return handle
        if (!isset($previousCommand['next_step']) || empty($previousCommand['next_step']))
            return true;

        /*
         * get condition which this command is executed, is the next step of previous command.
         * if it is incorrect step, execute fail step action method of the prevoius command
         * */
        $this->hasAccess = in_array($this::class, $previousCommand['next_step']);
        if ($this->hasAccess)
            return true;

        // check if command class or its method exists.
        if (class_exists($previousCommand['command']) && method_exists($previousCommand['command'], 'failStepAction')) {
            // execute custom fail action and return false
            (new $previousCommand['command']())->failStepAction($this->chat_id, $update);
            return false;
        } else {
            // log and throw exception
            Log::error(
                "Class or method of cached command, doesn't exists.[" . __METHOD__ . "]",
                ['class' => $previousCommand['command']]
            );
            throw new TelegramSDKException("Class or method of cached command, doesn't exists. see Log.");
            return false;
        }
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
        // get chat id
        $this->chat_id = $update->getMessage()->chat->id;

        // execute action before check nextStep validation
        $this->actionBeforeMake();

        // check nextStep validation
        if ($this->nextStepValidation($update) === false) {
            return false;
        }

        return $this->handle();
    }

    /**
     * cache nextSteps when class destruct
     * */
    public function __destruct()
    {
        if ($this->shouldCacheNextStep && $this->hasAccess) {
            // chcek if current command is instance of CommandStepByStep, save the nextSteps, otherwise if the prevoius
            $cacheData = [
                'command' => $this::class,
                'next_step' => $this->nextSteps()
            ];

            // save cache
            Cache::set($this->chat_id, $cacheData);
        }
    }

    /**
     * remove cache for current chatID
     *
     * @return bool
     * */
    public function removeCache(): bool
    {
        return Cache::delete($this->chat_id);
    }

}
