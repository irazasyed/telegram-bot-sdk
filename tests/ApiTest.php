<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Api;
use Prophecy\Prophet;
use Prophecy\Argument;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\TelegramClient;
use GuzzleHttp\Handler\MockHandler;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Tests\Mocks\MockCommand;
use Telegram\Bot\Tests\Mocks\MockCommandTwo;
use Telegram\Bot\HttpClients\GuzzleHttpClient;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Api
     */
    protected $api;
    /**
     * @var Prophet
     */
    protected $prophet;

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

    /**
     * @test
     * @dataProvider badTypes
     * @expectedException InvalidArgumentException
     * @link https://phpunit.de/manual/3.7/en/appendixes.annotations.html#appendixes.annotations.dataProvider
     */
    public function it_should_only_allow_a_string_as_the_api_token($type)
    {
        $this->api->setAccessToken($type);
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
     * @test
     * @expectedException Telegram\Bot\Exceptions\TelegramSDKException
     */
    function it_should_throw_exception_if_supplied_command_class_does_not_exist()
    {
        $this->api->addCommand('nonexistclass');
    }

    /**
     * @test
     * @expectedException Telegram\Bot\Exceptions\TelegramSDKException
     */
    function it_should_check_a_supplied_command_object_is_of_the_correct_type()
    {
        $this->api->addCommand(new \stdClass());
    }

    /** @test */
    function it_should_remove_a_command()
    {
        $this->api->addCommands([MockCommand::class, MockCommandTwo::class]);
        $this->api->removeCommand('mycommand');

        $commands = $this->api->getCommands();

        $this->assertCount(1, $commands);
        $this->assertArrayNotHasKey('mycommand', $commands);
        $this->assertInstanceOf(MockCommandTwo::class, $commands['mycommand2']);
    }

    /** @test */
    public function it_should_remove_multiple_commands()
    {
        $this->api->addCommands([MockCommand::class, MockCommandTwo::class]);
        $this->api->removeCommands(['mycommand', 'mycommand2']);

        $commands = $this->api->getCommands();

        $this->assertCount(0, $commands);
        $this->assertArrayNotHasKey('mycommand', $commands);
        $this->assertArrayNotHasKey('mycommand2', $commands);
    }

    /**
     * Shortcut to setTelegramResponse().
     *
     * @param string $message
     */
    private function setTelegramTextResponse($message = '/start')
    {
        $response = [
            'result' => [
                ['message' => ['text' => $message]],
            ],
        ];
        $this->setTelegramResponse($response);
    }

    /**
     * Recreates the Api object, using a mock http client, with predefined
     * responses containing the provided $body.
     *
     * @param $body
     */
    private function setTelegramResponse($body)
    {
        $body = json_encode($body);
        $mock = new MockHandler([
            new Response(200, [], $body),
            new Response(200, [], $body), // two times because Api::commandsHandler makes two requests
        ]);
        $handler = HandlerStack::create($mock);
        $client = new GuzzleHttpClient(new Client(['handler' => $handler]));

        $this->api = new Api('token', false, $client);
    }

    /**
     * Creates a stub command that responds to getName() and make() method calls.
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

    /**
     * Gets an array of arrays.
     *
     * These are types of data that should not be allowed to be used
     * as an API token.
     *
     * @return array
     */
    public function badTypes()
    {
        return [
            [
                new \stdClass()
            ],
            [
                ['token']
            ],
            [
                12345
            ]
        ];
    }
}