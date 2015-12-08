<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Api;
use Prophecy\Argument;
use InvalidArgumentException;
use Telegram\Bot\HttpClients\GuzzleHttpClient;
use Telegram\Bot\Objects\File;
use Telegram\Bot\Objects\Location;
use Telegram\Bot\Objects\User;
use Telegram\Bot\TelegramClient;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\TelegramResponse;
use Telegram\Bot\Tests\Mocks\Mocker;
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
    public function it_only_allows_a_string_as_the_api_token($type)
    {
        $this->api->setAccessToken($type);
    }

    public function testReturnsPassedToken()
    {
        $this->assertEquals('token', $this->api->getAccessToken());
        $this->api->setAccessToken('another');
        $this->assertEquals('another', $this->api->getAccessToken());
    }

    /** @test */
    public function it_allows_guzzle_to_be_passed_as_a_string_during_construction_of_api()
    {
        $this->api = new Api('token', false, 'guzzle');

        $client = $this->api->getClient()->getHttpClientHandler();

        $this->assertInstanceOf(GuzzleHttpClient::class, $client);
    }

    /** @test
     * @expectedException InvalidArgumentException
     */
    public function it_throws_exception_if_httpclient_is_not_specified_correctly()
    {
        $this->api = new Api('token', false, 'test');
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
        $this->api = Mocker::createMessageResponse('/start');
        $updates = $this->api->commandsHandler();
        $this->assertInstanceOf(Update::class, $updates[0]);
    }

    public function testHandlesTheRightCommand()
    {
        $this->api = Mocker::createMessageResponse('/mycommand');
        $command = Mocker::createMockCommand('mycommand');
        $command2 = Mocker::createMockCommand('mycommand2');

        $this->api->addCommands([$command->reveal(), $command2->reveal()]);

        $this->api->commandsHandler();

        $command->make(Argument::any(), Argument::any(), Argument::any())->shouldHaveBeenCalled();
        $command2->make(Argument::any(), Argument::any(), Argument::any())->shouldNotHaveBeenCalled();
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_throws_exception_if_supplied_command_class_does_not_exist()
    {
        $this->api->addCommand('nonexistclass');
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_checks_a_supplied_command_object_is_of_the_correct_type()
    {
        $this->api->addCommand(new \stdClass());
    }

    /** @test */
    public function it_removes_a_command()
    {
        $this->api->addCommands([MockCommand::class, MockCommandTwo::class]);
        $this->api->removeCommand('mycommand');

        $commands = $this->api->getCommands();

        $this->assertCount(1, $commands);
        $this->assertArrayNotHasKey('mycommand', $commands);
        $this->assertInstanceOf(MockCommandTwo::class, $commands['mycommand2']);
    }

    /** @test */
    public function it_removes_multiple_commands()
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
    public function it_throws_exception_if_inbound_message_has_blank_text()
    {
        $this->api = Mocker::createMessageResponse('');

        $this->api->commandsHandler();
    }

    /** @test */
    public function it_checks_the_lastResponse_property_gets_populated_after_a_request()
    {
        $this->assertEmpty($this->api->getLastResponse());

        $this->api = Mocker::createMessageResponse('/start');
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
    public function it_throws_an_exception_if_the_api_response_is_not_ok()
    {
        $this->api = Mocker::createApiResponse([], false);

        $this->api->getMe();
    }

    /** @test */
    public function it_checks_a_user_object_is_returned_when_getMe_is_requested()
    {
        $this->api = Mocker::createApiResponse(
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
    public function it_checks_a_message_object_is_returned_when_sendMessage_is_sent()
    {
        $chatId = 987654321;
        $text = 'Test message';
        $this->api = Mocker::createApiResponse(
            [
                'chat' => [
                    'id' => $chatId,
                ],
                'text' => $text,
            ]
        );

        /** @var Message $response */
        $response = $this->api->sendMessage(['chat_id' => $chatId, 'text' => $text]);

        $this->assertInstanceOf(Message::class, $response);
        $this->assertEquals($chatId, $response->getChat()->getId());
        $this->assertEquals($text, $response->getText());
    }

    /** @test */
    public function it_checks_a_message_object_is_returned_when_forwardMessage_is_sent()
    {
        $chatId = 987654321;
        $fromId = 888888888;
        $forwardFromId = 77777777;
        $messageId = 123;
        $this->api = Mocker::createApiResponse(
            [
                'message_id'   => $messageId,
                'from'         => [
                    'id' => $fromId,
                ],
                'forward_from' => [
                    'id' => $forwardFromId,
                ],
                'chat'         => [
                    'id' => $chatId,
                ],
            ]
        );

        /** @var Message $response */
        $response = $this->api->forwardMessage([
            'chat_id'      => $chatId,
            'from_chat_id' => $fromId,
            'message_id'   => $messageId,
        ]);

        $this->assertInstanceOf(Message::class, $response);
        $this->assertEquals($chatId, $response->getChat()->getId());
        $this->assertEquals($fromId, $response->getFrom()->getId());
        $this->assertEquals($messageId, $response->getMessageId());
        $this->assertEquals($forwardFromId, $response->getForwardFrom()->getId());
    }


    /** @test */
    public function it_checks_a_message_object_is_returned_with_photo_information_when_sendPhoto_is_sent()
    {
        $chatId = 987654321;
        $photo = md5('test'); //A file_id from a previous sent image.
        $this->api = Mocker::createApiResponse(
            [
                'chat'  => [
                    'id' => $chatId,
                ],
                'photo' => [
                    [
                        'file_id' => $photo,
                    ],
                    [
                        'file_id' => md5('file_id2'),
                    ],
                    [
                        'file_id' => md5('file_id3'),
                    ],
                ],
            ]
        );

        /** @var Message $response */
        $response = $this->api->sendPhoto(['chat_id' => $chatId, 'photo' => $photo]);

        $this->assertInstanceOf(Message::class, $response);
        $this->assertTrue($response->has('photo'));
        $this->assertTrue($response->getPhoto()->contains('file_id', $photo));
        $this->assertGreaterThan(1, count($response->getPhoto()));
    }

    /**
     * @test
     * @dataProvider fileTypes
     *
     * @param $fileType
     */
    public function it_checks_a_message_object_is_returned_with_correct_fields_when_all_fileTypes_are_attached_to_a_message(
        $fileType
    ) {
        $chatId = 987654321;
        $fileId = md5($fileType);

        //When sending all types of multimedia/documents these fields are always required:
        $requiredFields = [
            'chat'    => [
                'id' => $chatId,
            ],
            $fileType => [
                [
                    'file_id' => $fileId,
                ],
            ],
        ];

        //Photo message is slightly different as it returns multiple file_ids in an array.
        if ($fileType === 'photo') {
            $extraFileIds = [
                [
                    'file_id' => md5('file_id2'),
                ],
                [
                    'file_id' => md5('file_id3'),
                ],
            ];
            $requiredFields[$fileType] = array_merge($requiredFields[$fileType], $extraFileIds);
        }

        $this->api = Mocker::createApiResponse($requiredFields);

        /** @var Message $response */
        $method = 'send'.ucfirst($fileType);
        $response = $this->api->$method(['chat_id' => $chatId, $fileType => $fileId]);

        $this->assertInstanceOf(Message::class, $response);
        $this->assertTrue($response->has($fileType));
        $this->assertTrue($response->get($fileType)->contains('file_id', $fileId));

        if ($fileType === 'photo') {
            $this->assertGreaterThan(1, count($response->getPhoto()));
        }
    }

    /** @test */
    public function it_checks_a_message_object_is_returned_with_correct_fields_when_sendLocation_is_sent()
    {
        $chatId = 987654321;

        $requiredFields = [
            'chat'     => [
                'id' => $chatId,
            ],
            'location' => [
                'longitude' => 10.9,
                'latitude'  => 99.9,
            ],
        ];


        $this->api = Mocker::createApiResponse($requiredFields);

        /** @var Message $response */
        $response = $this->api->sendLocation(['chat_id' => $chatId, 'longitude' => 10.9, 'latitude' => 99.9]);

        $this->assertInstanceOf(Message::class, $response);
        $this->assertTrue($response->has('location'));
        $this->assertTrue($response->get('location')->has('longitude'));
        $this->assertTrue($response->get('location')->has('latitude'));
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_throws_exception_if_invalid_chatAction_is_sent()
    {
        $this->api->sendChatAction(['action' => 'zzz']);
    }

    /** @test */
    public function it_returns_a_successful_response_if_a_valid_chatAction_is_sent()
    {
        $this->api = Mocker::createApiResponse([true]);

        $response = $this->api->sendChatAction(['chat_id' => 123456789, 'action' => 'typing']);

        $this->assertInstanceOf(TelegramResponse::class, $response);
        $this->assertTrue($response->getDecodedBody()['result'][0]);
        $this->assertEquals(200, $response->getHttpStatusCode());
    }

    /** @test */
    public function it_returns_a_file_object_if_getFile_is_sent()
    {
        $fileId = md5('file_id');
        $this->api = Mocker::createApiResponse(
            [
                'file_id'   => $fileId,
                'file_size' => '',
                'file_path' => '',
            ]
        );

        $response = $this->api->getFile(['file_id' => $fileId]);

        $this->assertInstanceOf(File::class, $response);
        $this->assertEquals($fileId, $response->getFileId());
    }

    /**
     * @test
     * @dataProvider jsonMethods
     *
     * @param $methodName
     */
    public function it_checks_json_is_returned($methodName)
    {
        $params = [];
        $result = $this->api->$methodName($params);

        $this->assertJson($result);
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_throws_an_exception_if_setWebhook_url_is_not_a_url()
    {
        $this->api->setWebhook(['url' => 'string']);
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function it_throws_an_exception_if_webhook_url_is_not_a_https_url()
    {
        $this->api->setWebhook(['url' => 'http://example.com']);
    }

    /** @test */
    public function it_returns_a_successful_message_object_if_correct_webhook_is_sent()
    {
        $this->api = Mocker::createApiResponse([true]);

        $response = $this->api->setWebhook(['url' => 'https://example.com']);

        $this->assertInstanceOf(Message::class, $response);
        $this->assertTrue($response[0]);
    }

    /** @test */
    public function it_returns_a_successful_response_object_when_webhook_removed()
    {
        $this->api = Mocker::createApiResponse([true]);

        $response = $this->api->removeWebhook();

        $this->assertInstanceOf(TelegramResponse::class, $response);
        $this->assertTrue($response->getDecodedBody()['result'][0]);
        $this->assertEquals(200, $response->getHttpStatusCode());
    }

    /**
     * A list of files/attachments types that should be tested.
     *
     * @return array
     */
    public function fileTypes()
    {
        return [
            [
                'photo',
            ],
            [
                'audio',
            ],
            [
                'video',
            ],
            [
                'voice',
            ],
            [
                'sticker',
            ],
            [
                'document',
            ],
        ];
    }

    /**
     * A list of methods that must return json data.
     *
     * @return array
     */
    public function jsonMethods()
    {
        return [
            [
                'replyKeyboardMarkup',
            ],
            [
                'replyKeyboardHide',
            ],
            [
                'forceReply',
            ],
        ];
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
