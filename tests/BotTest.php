<?php

namespace Telegram\Bot\Tests;

use PHPUnit_Framework_TestCase;
use Telegram\Bot\Bots\Bot;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Tests\Mocks\Mocker;

class BotTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Bot
     */
    protected $bot;

    public function setUp()
    {
        $this->bot = new Bot('testbot', Mocker::createApi()->reveal());
    }

    /** @test */
    public function it_checks_the_name_can_be_set()
    {
        $this->assertEquals('testbot', $this->bot->getName());
        $this->bot->setName('another');
        $this->assertEquals('another', $this->bot->getName());
    }
    
    /** @test */
    public function it_emits_update_events()
    {
        $emittedEvent = null;
        $this->bot->addUpdateListener(function ($event) use (&$emittedEvent) {
            $emittedEvent = $event;
        });
        $this->bot->processUpdate(Mocker::createUpdateObject()->reveal());
        
        $this->assertInstanceOf(UpdateWasReceived::class, $emittedEvent);
        
    }
    
    /** @test */
    public function it_checks_an_update_object_is_returned_when_an_update_is_handled()
    {
        $this->bot = new Bot('testbot', Mocker::createMessageResponse('/start'));        
        $updates = $this->bot->checkForUpdates();
        $this->assertInstanceOf(Update::class, $updates[0]);
    }
}
