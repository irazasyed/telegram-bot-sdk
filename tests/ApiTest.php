<?php

namespace Telegram\Bot\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Prophecy\Argument;
use Prophecy\Prophet;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\HttpClients\GuzzleHttpClient;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\TelegramClient;
use Telegram\Bot\Tests\Mocks\MockCommand;
use Telegram\Bot\Tests\Mocks\MockCommandTwo;

class ApiTest extends \PHPUnit_Framework_TestCase
{

    protected $api, $prophet;

    public function setUp()
    {
        $this->api = new Api('token');
        $this->prophet = new Prophet();
    }

    /**
     * @expectedException Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function testThrowsExceptionOnNullToken()
    {
        new Api();
    }

    public function testReturnsPassedToken()
    {
        $this->assertEquals('token', $this->api->getAccessToken());
        $this->api->setAccessToken('another');
        $this->assertEquals('another', $this->api->getAccessToken());
    }

    public function testReturnsClientObject()
    {
        $this->assertInstanceOf(TelegramClient::class, $this->api->getClient());
    }

    public function testReturnsCommandBus()
    {
        $this->assertInstanceOf(CommandBus::class, $this->api->getCommandBus());
    }

    public function testAddsAndReturnsInstantiatedCommands()
    {
        $this->api->addCommand(MockCommand::class);
        $commands = $this->api->getCommands();
        $this->assertInstanceOf(MockCommand::class, $commands['mycommand']);
    }

    public function testAddsMultipleCommands()
    {
        $this->api->addCommands([MockCommand::class, MockCommandTwo::class]);
        $commands = $this->api->getCommands();
        $this->assertInstanceOf(MockCommand::class, $commands['mycommand']);
        $this->assertInstanceOf(MockCommandTwo::class, $commands['mycommand2']);
    }

    public function testCommandsHandlerReturnsUpdates()
    {
        $this->setTelegramTextResponse('/start');
        $updates = $this->api->commandsHandler();
        $this->assertInstanceOf(Update::class, $updates[0]);
    }

    public function testHandlesTheRightCommand()
    {
        $this->setTelegramTextResponse('/mycommand');
        $command = $this->addStubCommand('mycommand');
        $command2 = $this->addStubCommand('mycommand2');

        $this->api->commandsHandler();

        $command->make(Argument::any(), Argument::any(), Argument::any())->shouldHaveBeenCalled();
        $command2->make(Argument::any(), Argument::any(), Argument::any())->shouldNotHaveBeenCalled();
    }

    /**
     * Shortcut to setTelegramResponse()
     *
     * @param string $message
     */
    private function setTelegramTextResponse($message = '/start')
    {
        $response = [
            'result' => [
                ['message' => ['text' => $message]]
            ]
        ];
        $this->setTelegramResponse($response);
    }

    /**
     * Recreates the Api object, using a mock http client, with predefined
     * responses containing the provided $body
     *
     * @param $body
     */
    private function setTelegramResponse($body)
    {
        $body = json_encode($body);
        $mock = new MockHandler([
            new Response(200, [], $body),
            new Response(200, [], $body) // two times because Api::commandsHandler makes two requests
        ]);
        $handler = HandlerStack::create($mock);
        $client = new GuzzleHttpClient(new Client(['handler' => $handler]));

        $this->api = new Api('token', false, $client);
    }

    /**
     * Creates a stub command that responds to getName() and make() method calls
     *
     * @param string $name
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    private function addStubCommand($name = 'start')
    {
        $command = $this->prophet->prophesize(MockCommand::class);
        $command->getName()->willReturn($name);
        $command->make(Argument::any(), Argument::any(), Argument::any())->willReturn(null);

        $this->api->addCommand($command->reveal());

        return $command;
    }

}