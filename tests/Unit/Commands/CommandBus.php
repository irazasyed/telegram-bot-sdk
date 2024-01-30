<?php

use Illuminate\Support\Collection;
use Prophecy\PhpUnit\ProphecyTrait;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Tests\Traits\CommandGenerator;

uses(ProphecyTrait::class, CommandGenerator::class);

beforeEach(function () {
    $this->bus = new CommandBus();
});

it('can add a command to the bus', function () {
    $this->bus->addCommand($this->commandGenerator(1)->first());
    $result = $this->bus->getCommands();

    expect($result)->toHaveCount(1);
});

it('can get all commands from the bus', function () {
    $this->bus->addCommands($this->commandGenerator(3)->all());
    $result = $this->bus->getCommands();

    expect($result)->toHaveCount(3);
});

it('can add multiple commands to the bus', function () {
    $this->bus->addCommands($this->commandGenerator(4)->all());
    $result = $this->bus->getCommands();

    expect($result)->toHaveCount(4);
});

it('can add multiple commands contained in an iterator to the bus', function () {
    $iterator = new ArrayIterator($this->commandGenerator(4)->all());

    $this->bus->addCommands($iterator);
    $result = $this->bus->getCommands();

    expect($result)->toHaveCount(4);
});

it('throws an exception if a no class exists for the name supplied as a command')
    ->tap(fn () => $this->bus->addCommand('badcommand'))
    ->throws(TelegramSDKException::class);

it('throws an exception if a commands alias matches a previously added command alias', function () {
    $this->bus->addCommands($this->commandGenerator(3)->all());

    $mockCommand = $this->prophesize(Command::class);
    $mockCommand->getName()->willReturn('MockCommand4');
    $mockCommand->getAliases()->willReturn(['MockAlias2']);

    $this->bus->addCommand($mockCommand->reveal());
})->throws(TelegramSDKException::class);

it('throws an exception if a commands alias matches a previously added command name', function () {
    $this->expectException(TelegramSDKException::class);
    $this->bus->addCommands($this->commandGenerator(3)->all());

    $mockCommand = $this->prophesize(Command::class);
    $mockCommand->getName()->willReturn('MockCommand4');
    $mockCommand->getAliases()->willReturn(['MockCommand1']);

    $this->bus->addCommand($mockCommand->reveal());
});

it('can remove a command from the bus', function () {
    $this->bus->addCommands($this->commandGenerator(4)->all());

    $result = $this->bus->getCommands();
    $commandNames = getAllCommandNames($result);

    expect($result)->toHaveCount(4);
    $this->assertStringContainsString('MockCommand3', $commandNames);

    //Remove Specific command.
    $this->bus->removeCommand('MockCommand3');

    $newResult = $this->bus->getCommands();
    $newCommandNames = getAllCommandNames($newResult);

    expect($newResult)->toHaveCount(3)
        ->and($newCommandNames)->not->toContain('MockCommand3');
    $this->assertStringContainsString('MockCommand1', $newCommandNames);
});

it('can remove multiple commands from the bus', function () {
    $this->bus->addCommands($this->commandGenerator(4)->all());

    $result = $this->bus->getCommands();
    $commandNames = getAllCommandNames($result);

    expect($result)->toHaveCount(4);
    $this->assertStringContainsString('MockCommand1', $commandNames);
    $this->assertStringContainsString('MockCommand4', $commandNames);

    //Remove multiple commands at once
    $this->bus->removeCommands(['MockCommand1', 'MockCommand4']);

    $newResult = $this->bus->getCommands();
    $newCommandNames = getAllCommandNames($newResult);

    expect($newResult)->toHaveCount(2)
        ->and($newCommandNames)->not->toContain('MockCommand1')
        ->and($newCommandNames)->not->toContain('MockCommand4');
    $this->assertStringContainsString('MockCommand2', $newCommandNames);
    $this->assertStringContainsString('MockCommand3', $newCommandNames);
});

it('can return the command name from a message correctly ignoring the slash', function () {
    $message01 = 'The command is /demo and is in the middle of the string.';
    $message02 = '/beginning command is at the start of a string.';

    $commandName01 = $this->bus->parseCommand($message01, 15, 5);
    $commandName02 = $this->bus->parseCommand($message02, 0, 10);

    expect($commandName01)->toEqual('demo')
        ->and($commandName02)->toEqual('beginning');
});

it('can parse a command from a group of bots', function () {
    $message01 = 'The command is /demo@MyDemo_Bot and is in the middle of the string.';
    $message02 = '/demo@MyDemo_Bot command is at the start of a string.';

    $commandName01 = $this->bus->parseCommand($message01, 15, 16);
    $commandName02 = $this->bus->parseCommand($message02, 0, 16);

    expect($commandName01)->toEqual('demo')
        ->and($commandName02)->toEqual('demo');
});

it('throws an exception if parsing for a command in a message with no text')
    ->tap(fn () => $this->bus->parseCommand('', 5, 5))
    ->throws(InvalidArgumentException::class);

it('throws an exception if command is not an instance of command interface', function () {
    $class = new class()
    {
    };

    $this->bus->addCommand($class::class);
})
    ->throws(TelegramSDKException::class);

function getAllCommandNames($result): Collection
{
    return collect($result)
        ->map(static fn (Command $command): string => $command->getName());
}
