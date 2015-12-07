<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Api;
use Prophecy\Argument;
use InvalidArgumentException;
use Telegram\Bot\Objects\User;
use Telegram\Bot\TelegramClient;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\TelegramResponse;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Tests\Mocks\MockCommand;
use Telegram\Bot\Tests\Mocks\MockCommandTwo;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Api
     */
    protected $api;

    public function setUp()
    {
        $this->api = new Api('token');
    }

    /**
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function testThrowsExceptionOnNullToken()
    {
        new Api();
    }

    /**
     * @test
     * @dataProvider badTypes
     * @expectedException InvalidArgumentException
     * @link         https://phpunit.de/manual/3.7/en/appendixes.annotations.html#appendixes.annotations.dataProvider
     *
     * @param mixed $type The item under test
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
        $this->api = TGMocks::createMessageResponse('/start');
        $updates = $this->api->commandsHandler();
        $this->assertInstanceOf(Update::class, $updates[0]);
    }

    public function testHandlesTheRightCommand()
    {
        $this->api = TGMocks::createMessageResponse('/mycommand');
        $command = TGMocks::createMockCommand('mycommand');
        $command2 = TGMocks::createMockCommand('mycommand2');

        $this->api->addCommands([$command->reveal(), $command2->reveal()]);

        $this->api->commandsHandler();

        $command->make(Argument::any(), Argument::any(), Argument::any())->shouldHaveBeenCalled();
        $command2->make(Argument::any(), Argument::any(), Argument::any())->shouldNotHaveBeenCalled();
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_should_throw_exception_if_supplied_command_class_does_not_exist()
    {
        $this->api->addCommand('nonexistclass');
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_should_check_a_supplied_command_object_is_of_the_correct_type()
    {
        $this->api->addCommand(new \stdClass());
    }

    /** @test */
    public function it_should_remove_a_command()
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
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_should_throw_exception_if_inbound_message_has_blank_text()
    {
        $this->api = TGMocks::createMessageResponse('');

        $this->api->commandsHandler();
    }

    /** @test */
    public function it_checks_the_lastResponse_property_gets_populated_after_a_request()
    {
        $this->assertEmpty($this->api->getLastResponse());

        $this->api = TGMocks::createMessageResponse('/start');
        $this->api->commandsHandler();

        $lastResponse = $this->api->getLastResponse();
        $this->assertNotEmpty($lastResponse);
        $this->assertInstanceOf(TelegramResponse::class, $lastResponse);
    }

    /** @test */
    public function it_checks_the_async_property_can_be_set()
    {
        $this->assertEmpty($this->api->isAsyncRequest());

        $this->api->setAsyncRequest(true);

        $isAsync = $this->api->isAsyncRequest();

        $this->assertTrue($isAsync);
        $this->assertInternalType('bool', $isAsync);
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramResponseException
     */
    public function it_should_throw_an_exception_if_the_api_response_is_not_ok()
    {
        $this->api = TGMocks::createApiResponse([], false);

        $this->api->getMe();
    }

    /** @test */
    public function it_checks_a_user_object_is_returned_when_getMe_is_requested()
    {
        $this->api = TGMocks::createApiResponse(
            [
                'id'         => 123456789,
                'first_name' => 'Test',
                'username'   => 'TestUsername',
            ]
        );

        /** @var User $response */
        $response = $this->api->getMe();

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals(123456789, $response->getId());
        $this->assertEquals('Test', $response->getFirstName());
        $this->assertEquals('TestUsername', $response->getUsername());
    }

    /** @test */
    public function it_checks_a_message_object_is_returned_when_sendMessage_is_executed()
    {
        $chatId = 987654321;
        $text = 'Test message';
        $this->api = TGMocks::createApiResponse(
            [
                'chat' => [
                    'id' => $chatId,
                ],
                'text' => $text,
            ]
        );

        /** @var Message $response */
        $response = $this->api->sendMessage(['chat_id' => $chatId, 'text' => $text, ]);

        $this->assertInstanceOf(Message::class, $response);
        $this->assertEquals($chatId, $response->getChat()->getId());
        $this->assertEquals($text, $response->getText());
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
                new \stdClass(),
            ],
            [
                ['token'],
            ],
            [
                12345,
            ],
        ];
    }
}
