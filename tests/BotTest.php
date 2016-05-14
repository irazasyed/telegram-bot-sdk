<?php

namespace Telegram\Bot\Tests;

use PHPUnit_Framework_TestCase;
use Telegram\Bot\Bots\Bot;
use Telegram\Bot\Tests\Mocks\Mocker;
use Telegram\Bot\Events\UpdateWasReceived;

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
        $this->bot->processUpdates([Mocker::createUpdateObject()->reveal()]);
        
        $this->assertInstanceOf(UpdateWasReceived::class, $emittedEvent);
        
    }
}
