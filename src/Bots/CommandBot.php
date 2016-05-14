<?php

namespace Telegram\Bot\Bots;

use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Objects\Update;


class CommandBot extends Bot
{
    
    /**
     * @var CommandBus Telegram Command Bus.
     */
    protected $commandBus = null;
    
    
    public function __construct($name = null, $api = null)
    {
        parent::__construct($name, $api);
        $this->commandBus = new CommandBus($this->getApi());
        
        $this->addUpdateListener(function(UpdateWasReceived $event){
            $this->processCommand($event->getUpdate());
        });
    }
    
    /**
     * Returns SDK's Command Bus.
     *
     * @return CommandBus
     */
    public function getCommandBus()
    {
        return $this->commandBus;
    }
    
    /**
     * Check update object for a command and process.
     *
     * @param Update $update
     */
    public function processCommand(Update $update)
    {
        $message = $update->getMessage();

        if ($message !== null && $message->has('text')) {
            $this->getCommandBus()->handler($message->getText(), $update);
        }
    }

    /**
     * Helper to Trigger Commands.
     *
     * @param string $name   Command Name
     * @param Update $update Update Object
     *
     * @return mixed
     */
    public function triggerCommand($name, Update $update)
    {
        return $this->getCommandBus()->execute($name, $update->getMessage()->getText(), $update);
    }
}
    
    
        

       