<?php

namespace Telegram\Bot\Tests\Unit\Commands;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\HelpCommand;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class HelpCommandTest extends TestCase
{
    /** @test it makes the make method work */
    public function it_ensures_a_command_make_method_works()
    {
        $update = new Update([
            'update_id' => 377695723,
            'message'   => [
                'message_id' => 999,
                'from'       => [
                    'id'         => 123456789,
                    'first_name' => 'John',
                    'last_name'  => 'Doe',
                    'username'   => 'jdoe',
                ],
                'chat'       => [
                    'id'         => 77777777,
                    'first_name' => 'John',
                    'last_name'  => 'Doe',
                    'username'   => 'jdoe',
                    'type'       => 'private',
                ],
                'date'       => 1494250044,
                'text'       => '/help',
                'entities'   => [
                    [
                        'type'   => 'bot_command',
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
        $result = $help->make($api->reveal(), $update, $entity);

        $api->getCommands()->shouldHaveBeenCalled();
        $api->sendMessage([
            'chat_id' => 77777777,
            'text'    => "/help - Help command, Get a list of commands\n",
        ])->shouldHaveBeenCalled();
    }
}
