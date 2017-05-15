<?php

namespace Telegram\Bot\Tests\Unit\Commands;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Tests\Traits\CommandGenerator;

class CommandBusTest extends TestCase
{

    use CommandGenerator;

    /**
     * @var CommandBus
     */
    protected $bus;

    protected function setup()
    {
        parent::setUp();
        $this->bus = new CommandBus();
    }

    /** @test it can add commands to the bus */
    public function it_can_add_a_command_to_the_bus()
    {
        $this->bus->addCommand($this->commandGenerator(1)->first());
        $result = $this->bus->getCommands();

        $this->assertCount(1, $result);
    }

    /** @test */
    public function it_can_get_all_commands_from_the_bus()
    {
        $this->bus->addCommands($this->commandGenerator(3)->all());
        $result = $this->bus->getCommands();

        $this->assertCount(3, $result);
    }

    /** @test */
    public function it_can_add_multiple_commands_to_the_bus()
    {
        $this->bus->addCommands($this->commandGenerator(4)->all());
        $result = $this->bus->getCommands();

        $this->assertCount(4, $result);
    }


    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_throws_an_exception_if_a_no_class_exists_for_the_name_supplied_as_a_command()
    {
        $this->bus->addCommand('badcommand');
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_throws_an_exception_if_command_is_not_an_instance_of_command_interface()
    {
        $this->bus->addCommand(new class
            {
            }
        );
    }


    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_throws_an_exception_if_a_commands_alias_matches_a_previously_added_command_alias()
    {
        $this->bus->addCommands($this->commandGenerator(3)->all());

        $mockCommand = $this->prophesize(Command::class);
        $mockCommand->getName()->willReturn("MockCommand4");
        $mockCommand->getAliases()->willReturn(["MockAlias2"]);

        $this->bus->addCommand($mockCommand->reveal());
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_throws_an_exception_if_a_commands_alias_matches_a_previously_added_command_name()
    {
        $this->bus->addCommands($this->commandGenerator(3)->all());

        $mockCommand = $this->prophesize(Command::class);
        $mockCommand->getName()->willReturn("MockCommand4");
        $mockCommand->getAliases()->willReturn(["MockCommand1"]);

        $this->bus->addCommand($mockCommand->reveal());
    }


    /** @test */
    public function it_can_remove_a_command_from_the_bus()
    {
        $this->bus->addCommands($this->commandGenerator(4)->all());

        $result = $this->bus->getCommands();
        $commandNames = $this->getAllCommandNames($result);

        $this->assertCount(4, $result);
        $this->assertContains('MockCommand3', $commandNames);

        //Remove Specific command.
        $this->bus->removeCommand('MockCommand3');

        $newResult = $this->bus->getCommands();
        $newCommandNames = $this->getAllCommandNames($newResult);

        $this->assertCount(3, $newResult);
        $this->assertNotContains('MockCommand3', $newCommandNames);
        $this->assertContains('MockCommand1', $newCommandNames);
    }

    /** @test */
    public function it_can_remove_multiple_commands_from_the_bus()
    {
        $this->bus->addCommands($this->commandGenerator(4)->all());

        $result = $this->bus->getCommands();
        $commandNames = $this->getAllCommandNames($result);

        $this->assertCount(4, $result);
        $this->assertContains('MockCommand1', $commandNames);
        $this->assertContains('MockCommand4', $commandNames);

        //Remove multiple commands at once
        $this->bus->removeCommands(['MockCommand1', 'MockCommand4']);

        $newResult = $this->bus->getCommands();
        $newCommandNames = $this->getAllCommandNames($newResult);

        $this->assertCount(2, $newResult);
        $this->assertNotContains('MockCommand1', $newCommandNames);
        $this->assertNotContains('MockCommand4', $newCommandNames);
        $this->assertContains('MockCommand2', $newCommandNames);
        $this->assertContains('MockCommand3', $newCommandNames);
    }

    /** @test */
    public function it_can_return_the_command_name_from_a_message_correctly_ignoring_the_slash()
    {
        $message01 = "The command is /demo and is in the middle of the string.";
        $message02 = "/beginning command is at the start of a string.";

        $commandName01 = $this->bus->parseCommand($message01, 15, 5);
        $commandName02 = $this->bus->parseCommand($message02, 0, 10);

        $this->assertEquals('demo', $commandName01);
        $this->assertEquals('beginning', $commandName02);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_throws_an_exception_if_parsing_for_a_command_in_a_message_with_no_text()
    {
        $message = "";

        $this->bus->parseCommand($message, 5, 5);
    }

    /**
     * @param $result
     *
     * @return Collection
     */
    private function getAllCommandNames($result): Collection
    {
        return collect($result)
            ->map(function (Command $command) {
                return $command->getName();
            });
    }
}
