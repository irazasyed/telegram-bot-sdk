<?php

namespace Telegram\Bot\Tests;

use PHPUnit_Framework_TestCase;
use Telegram\Commands\CommandBot;
use Telegram\CommandBus;
use Telegram\Bot\Tests\Mocks\Mocker;

class CommandBotTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Bot
     */
    protected $bot;

    public function setUp()
    {
        $this->bot = new CommandBot('testbot', Mocker::createApi()->reveal());
    }

    /** @test */
    public function it_checks_the_commandBus_is_returned()
    {
        $this->assertInstanceOf(CommandBus::class, $this->bot->getCommandBus());
    }
    
    /** @test */
    public function it_checks_the_correct_command_is_handled()
    {
        $this->api = Mocker::createMessageResponse('/mycommand');
        $command = Mocker::createMockCommand('mycommand');
        $command2 = Mocker::createMockCommand('mycommand2');

        $this->api->addCommands([$command->reveal(), $command2->reveal()]);

        $this->api->commandsHandler();

        $command->make(Argument::any(), Argument::any(), Argument::any())->shouldHaveBeenCalled();
        $command2->make(Argument::any(), Argument::any(), Argument::any())->shouldNotHaveBeenCalled();
    }
}
