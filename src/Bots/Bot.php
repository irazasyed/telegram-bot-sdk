<?php

namespace Telegram\Bot\Bots;

use League\Event\Emitter;
use Telegram\Bot\Api;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Events\EmitsEvents;

class Bot{
        
    use EmitsEvents;
    
    protected $api = null;
    
    protected $name = null;
    
    public function __construct($name = null, Api $api = null)
    {
        
        if($api === null){
            $this->api = new Api();
        }else{
            $this->api = $api;
        }
        
        $this->name = $name;
        $this->setEventEmitter(new Emitter());
    }
    
    public function getApi(){
        return $this->api;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
    }
    
    public function checkForUpdates($webhook = false, $params = []){
        if($webhook){
            $updates = $this->api->getWebhookUpdates();
        }else{
            $updates = $this->api->getUpdates($params);
        }        
        $this->processUpdates($updates);
        
        $highestUpdateId = $updates[count($updates) - 1]->getUpdateId();
        if ($highestUpdateId != -1) {
            $this->api->confirmUpdate($highestUpdateId);
        }
        return $updates;
    }
    
    function processUpdates($updates){
        foreach ($updates as $update){
            $this->emitEvent(new UpdateWasReceived($update, $this));
        }
    }
    
    function addUpdateListener($listener){
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
