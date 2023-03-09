<?php

use Prophecy\Argument;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\HelpCommand;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

uses(\Prophecy\PhpUnit\ProphecyTrait::class);
it('ensures a command make method works', function () {
    $update = new Update([
        'update_id' => 377_695_723,
        'message' => [
            'message_id' => 999,
            'from' => [
                'id' => 123_456_789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
            ],
            'chat' => [
                'id' => 77_777_777,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
                'type' => 'private',
            ],
            'date' => 1_494_250_044,
            'text' => '/help',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 5,
                ],
            ],
        ],
    ]);
    $help = new HelpCommand();
    $api = $this->prophesize(Api::class);
    $api->getCommands()->willReturn(['help' => $help]);
    $api->sendMessage(Argument::type('array'))->willReturn($this->prophesize(Message::class)->reveal());

    $entity = $update->getMessage()->entities->get(0)->toArray();
    $help->make($api->reveal(), $update, $entity);

    $api->getCommands()->shouldHaveBeenCalled();
    $api->sendMessage([
        'chat_id' => 77_777_777,
        'text' => "/help - Help command, Get a list of commands\n",
    ])->shouldHaveBeenCalled();
});
