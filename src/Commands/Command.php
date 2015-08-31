<?php

namespace Irazasyed\Telegram\Commands;

use Irazasyed\Telegram\Telegram;
use Irazasyed\Telegram\Exceptions\TelegramSDKException;

abstract class Command implements CommandInterface
{
    /**
     * The name of the Telegram command.
     * Ex: help - Whenever the user sends /help, this would be resolved.
     *
     * @var string
     */
    protected $name;

    /**
     * @var string The Telegram command description.
     */
    protected $description;

    /**
     * @var Telegram Holds the Super Class Instance.
     */
    protected $telegram;

    /**
     * @var string Arguments passed to the command.
     */
    protected $arguments;

    /**
     * @var array Holds an Update object.
     */
    protected $update;


    /**
     * Get Command Name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Command Name.
     *
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Command Description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Command Description.
     *
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns Telegram Instance.
     *
     * @return Telegram
     */
    public function getTelegram()
    {
        return $this->telegram;
    }

    /**
     * Returns Original Update.
     *
     * @return array
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * Get Arguments passed to the command.
     *
     * @return string
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Returns an instance of Command Bus.
     *
     * @return \Irazasyed\Telegram\Commands\CommandBus
     */
    public function getCommandBus()
    {
        return $this->telegram->getCommandBus();
    }

    /**
     * @inheritdoc
     */
    public function make($telegram, $arguments, $update)
    {
        $this->telegram = $telegram;
        $this->update = $update;
        $this->arguments = $arguments;

        return $this->handle($arguments);
    }

    /**
     * Helper to Trigger other Commands.
     *
     * @param      $command
     * @param null $arguments
     *
     * @return mixed
     */
    protected function triggerCommand($command, $arguments = null)
    {
        return $this->getCommandBus()->execute($command, $arguments ?: $this->arguments, $this->update);
    }

    /**
     * @inheritdoc
     */
    abstract public function handle($arguments);

    /**
     * Magic Method to handle all ReplyWith Methods.
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed|string
     */
    public function __call($method, $arguments)
    {
        $action = substr($method, 0, 9);
        if ($action === 'replyWith') {
            $reply_name = studly_case(substr($method, 9));
            $methodName = 'send'.$reply_name;

            if (!method_exists($this->telegram, $methodName)) {
                return 'Method Not Found';
            }

            array_unshift($arguments, $this->update->getMessage()->getChat()->getId());

            return call_user_func_array([$this->telegram, $methodName], $arguments);
        }

        return 'Method Not Found';
    }
}
