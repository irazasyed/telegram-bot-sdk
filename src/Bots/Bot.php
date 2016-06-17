<?php

namespace Telegram\Bot\Bots;

use League\Event\Emitter;
use Telegram\Bot\Api;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Events\EmitsEvents;

class Bot
{
        
    use EmitsEvents;
    
    /**
     * @var Api Telegram Api
     */
    protected $api = null;
    
    /**
     * @var string Name of the bot
     */
    protected $name = null;
    
    /**
     * Creates new bot instance and corresponding Api if not given.
     *
     * @param string $name (Optional) Bot name
     * @param Api $api (Optional) Custom Api
     */
    public function __construct($name = null, Api $api = null)
    {
        
        if ($api === null) {
            $this->api = new Api();
        } else {
            $this->api = $api;
        }
        
        $this->name = $name;
        $this->setEventEmitter(new Emitter());
    }
    
    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Checks for pending telegram updates. If available, they get read, processed, confirmed and returned.
     *
     * @param boolean $webhook Signals to read update from webhook.
     * @param array $params See Api->getUpdates()
     * @return Update[]
     */
    public function checkForUpdates($webhook = false, $params = [])
    {
        if ($webhook) {
            $updates = $this->api->getWebhookUpdates();
        } else {
            $updates = $this->api->getUpdates($params);
        }
        
        $highestId = -1;
        foreach ($updates as $update) {
            $this->processUpdate($update);
            $highestId = $update->getUpdateId();
        }
        
        if ($highestId != -1) {
            $this->api->confirmUpdate($highestId);
        }
        return $updates;
    }
    
    /**
     * Process the Update. Here, emit a corresponding UpdateWasReceived Event.
     *
     * @param type $update
     */
    public function processUpdate($update)
    {
        $this->emitEvent(new UpdateWasReceived($update, $this));
    }
    
    /**
     * Adds a listener to be notified if an update was received.
     *
     * @param ListenerInterface|callable $listener
     */
    public function addUpdateListener($listener)
    {
        $this->getEventEmitter()->addListener(UpdateWasReceived::class, $listener);
    }
    
    /**
     * Magically pass methods to the api.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->getApi(), $method], $parameters);
    }
}
