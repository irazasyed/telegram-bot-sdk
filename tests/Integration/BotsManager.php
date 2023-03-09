<?php

use Telegram\Bot\BotsManager;
use Telegram\Bot\Exceptions\TelegramBotNotFoundException;

beforeEach(function () {
    $this->manager = new BotsManager(
        [
            'default' => 'bot1',
            'bots' => [
                'bot1' => [
                    'username' => 'BotOne_Bot',
                    'token' => 'TOKEN1',
                    'commands' => [],
                ],
                'bot2' => [
                    'username' => 'BotTwo_Bot',
                    'token' => 'TOKEN2',
                    'commands' => [],
                ],
                'bot3' => [
                    'username' => 'BotThree_Bot',
                    'token' => 'TOKEN3',
                    'commands' => [],
                ],
            ],
            'resolve_command_dependencies' => true,
            'commands' => [
                //      Telegram\Bot\Commands\HelpCommand::class,
            ],
        ]
    );
});

test('a bots manager can be created with no config', function () {
    $manager = new BotsManager([]);

    expect($manager)->toBeInstanceOf(BotsManager::class);
});

test('a bot must be configured before it can be used', function () {
    $this->expectException(TelegramBotNotFoundException::class);

    $manager = new BotsManager([]);
    $manager->bot('demo');
});

test('an invalid or missing config parameter returns null', function () {
    $manager = new BotsManager([]);

    $name = $manager->getDefaultBotName();

    expect($name)->toBeNull();
});

it('is possible to remove a bot from the manager but leave the others', function () {
    $this->manager->bot('bot1');
    $this->manager->bot('bot2');
    $this->manager->bot('bot3');

    expect($this->manager->getBots())->toHaveCount(3);

    $this->manager->disconnect('bot2');
    $remainingBots = $this->manager->getBots();

    expect($remainingBots)->toHaveCount(2);
    $this->assertArrayNotHasKey('bot2', $remainingBots);
    expect($remainingBots)->toHaveKey('bot1')
        ->and($remainingBots)->toHaveKey('bot3');
});

it('is possible to reconnect a bot that was disconnected or not used yet', function () {
    expect($this->manager->getBots())->toHaveCount(0);

    $this->manager->reconnect('bot1');

    expect($this->manager->getBots())
        ->toHaveCount(1)
        ->and($this->manager->getBots())
        ->toHaveKey('bot1');
});

//test('duplicated commands dont cause a problem', function () {
//    $manager = new BotsManager(
//        [
//            'commands' => [
//                'Acme\Project\Commands\Command1',
//            ],
//            'shared_commands' => [
//                'start' => 'Acme\Project\Commands\StartCommand',
//                'stop' => 'Acme\Project\Commands\StopCommand',
//                'status' => 'Acme\Project\Commands\StatusCommand',
//            ],
//            'command_groups' => [
//                'common' => [
//                    'Acme\Project\Commands\TodoCommand',
//                    'Acme\Project\Commands\TaskCommand',
//                    'Acme\Project\Commands\Command2',
//                ],
//                'subscription' => [
//                    'start',
//                    'stop',
//                ],
//                'parentgroup' => [
//                    'common',
//                    'subscription',
//                ],
//                'myBot' => [
//                    'admin', // Command Group Name.
//                    'subscription', // Command Group Name.
//                    'status', // Shared Command Name.
//                    'Acme\Project\Commands\BotCommand', // Full Path to Command Class.
//                ],
//            ],
//        ]
//    );
//
//    $commands01 = $manager->parseBotCommands([
//        'Acme\Project\Commands\Command1',
//        'Acme\Project\Commands\Command2',
//        'Acme\Project\Commands\Command3',
//    ]);
//
//    $commands02 = $manager->parseBotCommands([
//        'Acme\Project\Commands\Command2',
//        'Acme\Project\Commands\Command3',
//        'common',
//    ]);
//
//    $commands03 = $manager->parseBotCommands([
//        'Acme\Project\Commands\Command1',
//        'Acme\Project\Commands\Command2',
//        'Acme\Project\Commands\Command3',
//        'start',
//        'stop',
//        'subscription',
//    ]);
//
//    $commands04 = $manager->parseBotCommands([
//        'Acme\Project\Commands\Command1',
//        'Acme\Project\Commands\Command2',
//        'Acme\Project\Commands\Command3',
//        'parentgroup',
//    ]);
//
//    $commands05 = $manager->parseBotCommands([
//        'Acme\Project\Commands\Command1',
//        'Acme\Project\Commands\Command2',
//        'Acme\Project\Commands\Command3',
//        'myBot',
//    ]);
//
//    expect($commands01)->toHaveCount(3)
//        ->and($commands02)->toHaveCount(5)
//        ->and($commands03)->toHaveCount(5)
//        ->and($commands04)->toHaveCount(7)
//        ->and($commands05)->toHaveCount(8);
//})->skip('This test is not working properly');
