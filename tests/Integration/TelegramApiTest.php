<?php

namespace Telegram\Bot\Tests\Integration;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use League\Event\AbstractListener;
use League\Event\Emitter;
use League\Event\EventInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\CommandBus;
use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Exceptions\CouldNotUploadInputFile;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\HttpClients\GuzzleHttpClient;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\TelegramResponse;
use Telegram\Bot\Tests\Traits\CommandGenerator;
use Telegram\Bot\Tests\Traits\GuzzleMock;

class TelegramApiTest extends TestCase
{
    use GuzzleMock;
    use CommandGenerator;

    protected function tearDown(): void
    {
        // Prevent previous commands added to the bus lingering between
        // tests.
        CommandBus::destroy();
    }

    /**
     * @param  GuzzleHttpClient|null  $client
     * @param  string                 $token
     * @param  bool                   $async
     *
     * @throws TelegramSDKException
     * @return Api
     */
    protected function getApi($client = null, $token = 'TELEGRAM_TOKEN', $async = false)
    {
        return new Api($token, $async, $client);
    }

    /** Create Request to emulate income Request from Telegram. */
    private function createIncomeWebhookRequestInstance(array $updateData): Request
    {
        return new Request('POST', 'any', [], json_encode($updateData, \JSON_THROW_ON_ERROR));
    }

    /**
     * @test
     */
    public function the_bot_token_must_be_a_string(): void
    {
        $this->expectException(TelegramSDKException::class);
        $this->getApi(null, ['mytoken']);
    }

    /** @test */
    public function it_checks_the_default_http_client_is_guzzle_if_not_specified()
    {
        $api = $this->getApi(null);
        $client = $api->getClient()->getHttpClientHandler();

        $this->assertInstanceOf(GuzzleHttpClient::class, $client);
    }

    /** @test */
    public function a_guzzle_client_with_a_mock_queue_can_be_used_without_error()
    {
        $api = $this->getApi($this->getGuzzleHttpClient([]));

        $this->assertInstanceOf(Api::class, $api);
    }

    /** @test */
    public function a_normal_guzzle_client_with_no_mock_queue_can_be_used_without_error()
    {
        $api = $this->getApi(null);

        $this->assertInstanceOf(Api::class, $api);
    }

    /** @test */
    public function it_returns_an_empty_array_if_there_are_no_updates()
    {
        $data = [];
        $fakeResponse = $this->makeFakeServerResponse($data);

        $api = $this->getApi($this->getGuzzleHttpClient([$fakeResponse]));
        $result = $api->getUpdates();

        $this->assertCount(0, $result);
        $this->assertIsArray($result);
    }

    /** @test */
    public function the_correct_bot_url_is_used_when_a_request_is_made()
    {
        $data = [];
        $fakeResponse = $this->makeFakeServerResponse($data);

        $api = $this->getApi($this->getGuzzleHttpClient([$fakeResponse]), 'Special_Bot_Token');
        $api->getMe();

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('api.telegram.org', $request->getUri()->getHost());
        $this->assertEquals('/botSpecial_Bot_Token/getMe', $request->getUri()->getPath());
    }

    /** @test */
    public function the_correct_request_query_string_is_created_when_a_get_method_has_parameters()
    {
        $data = [];
        $fakeResponse = $this->makeFakeServerResponse($data);

        $api = $this->getApi($this->getGuzzleHttpClient([$fakeResponse]), 'Special_Bot_Token');
        $api->getChatMember([
            'chat_id' => 123456789,
            'user_id' => 888888888,
        ]);

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertEquals('', $request->getBody(), 'The get request had a body when it should be blank.');
        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('api.telegram.org', $request->getUri()->getHost());
        $this->assertEquals('/botSpecial_Bot_Token/getChatMember', $request->getUri()->getPath());
        $this->assertEquals('chat_id=123456789&user_id=888888888', $request->getUri()->getQuery());
    }

    /** @test */
    public function the_correct_request_body_data_is_created_when_a_post_method_has_parameters()
    {
        $data = [];
        $fakeResponse = $this->makeFakeServerResponse($data);
        $params = [
            'chat_id'                  => 12345678,
            'text'                     => 'lorem ipsum',
            'disable_web_page_preview' => true,
            'disable_notification'     => false,
            'reply_to_message_id'      => 99999999,
        ];

        $api = $this->getApi($this->getGuzzleHttpClient([$fakeResponse]), 'Special_Bot_Token');
        $api->sendMessage($params);

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertInstanceOf(Stream::class, $request->getBody());
        $this->assertEquals(http_build_query($params), (string) $request->getBody());
        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('api.telegram.org', $request->getUri()->getHost());
        $this->assertEquals('/botSpecial_Bot_Token/sendMessage', $request->getUri()->getPath());
        $this->assertEquals('', $request->getUri()->getQuery());
    }

    /** @test */
    public function it_returns_decoded_update_objects_when_updates_are_available()
    {
        $data1 = [
            [
                'update_id' => 377695760,
                'message'   => [
                    'message_id' => 749,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623093,
                    'text'       => 'Test1',
                ],
            ],
            [
                'update_id' => 377695761,
                'message'   => [
                    'message_id' => 750,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623095,
                    'text'       => 'Test2',
                ],
            ],
        ];
        $data2 = [
            [
                'update_id' => 377695762,
                'message'   => [
                    'message_id' => 751,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623093,
                    'text'       => 'Test3',
                ],
            ],
            [
                'update_id' => 377695763,
                'message'   => [
                    'message_id' => 752,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623095,
                    'text'       => 'Test4',
                ],
            ],
        ];
        $replyFromTelegram1 = $this->makeFakeServerResponse($data1);
        $replyFromTelegram2 = $this->makeFakeServerResponse($data2);

        $api = $this->getApi($this->getGuzzleHttpClient([$replyFromTelegram1, $replyFromTelegram2]));
        $firstUpdates = $api->getUpdates();
        $secondUpdates = $api->getUpdates();

        $this->assertCount(2, $firstUpdates);
        $this->assertEquals('377695760', $firstUpdates[0]->updateId);
        $this->assertEquals('Test1', $firstUpdates[0]->message->text);
        $this->assertEquals('377695761', $firstUpdates[1]->updateId);
        $this->assertEquals('Test2', $firstUpdates[1]->message->text);

        $this->assertCount(2, $secondUpdates);
        $this->assertEquals('377695762', $secondUpdates[0]->updateId);
        $this->assertEquals('Test3', $secondUpdates[0]->message->text);
        $this->assertEquals('377695763', $secondUpdates[1]->updateId);
        $this->assertEquals('Test4', $secondUpdates[1]->message->text);
    }

//    /** @test */
//    public function it_can_call_a_valid_method_on_the_api()
//    {
//        $mock = $this->prophesize(\Telegram\Bot\Api::class);
//        $mock->getConnectTimeOut()->willReturn(30);
//        $mock->getCommands()->willReturn([]);
//
//        $api = $mock->reveal();
//        $api->getConnectTimeOut();
//        $api->getCommands();
//
//        $mock->getConnectTimeOut()->shouldHaveBeenCalled();
//        $mock->getCommands()->shouldNotHaveBeenCalled();
//
//    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_a_method_called_does_not_exist()
    {
        $this->expectException(\BadMethodCallException::class);
        $badMethod = 'getBadMethod'; //To stop errors in ide!

        $api = $this->getApi();
        $api->$badMethod();
    }

    /** @test */
    public function it_checks_the_lastResponse_property_gets_populated_after_a_request()
    {
        $data = [
            [
                'update_id' => 377695760,
            ],
        ];
        $replyFromTelegram = $this->makeFakeServerResponse($data);
        $api = $this->getApi($this->getGuzzleHttpClient([$replyFromTelegram]));

        $this->assertEmpty($api->getLastResponse());

        $api->getUpdates();

        $lastResponse = $api->getLastResponse();
        $this->assertNotEmpty($lastResponse);
        $this->assertEquals('377695760', $lastResponse->getDecodedBody()['result'][0]['update_id']);
        $this->assertInstanceOf(TelegramResponse::class, $lastResponse);
    }

    /** @test */
    public function it_throws_an_exception_if_the_api_response_is_not_ok()
    {
        $badUpdateReply = $this->makeFakeServerErrorResponse(123, 'BadResponse Test');
        $api = $this->getApi($this->getGuzzleHttpClient([$badUpdateReply]));

        try {
            $api->getUpdates();
        } catch (TelegramResponseException $exception) {
            $this->assertEquals(123, $exception->getCode());
            $this->assertEquals('BadResponse Test', $exception->getMessage());

            return;
        }

        $this->fail('Should have caught an exception because the update waiting for us was not ok.');
    }

    /**
     * @test
     */
    public function it_throws_exception_if_invalid_chatAction_is_sent()
    {
        $this->expectException(TelegramSDKException::class);
        $this->getApi()->sendChatAction(['action' => 'zzz']);
    }

    /** @test */
    public function it_can_use_async_promises_to_send_requests()
    {
        $data = [
            [
                'update_id' => 377695763,
            ],
        ];
        $replyFromTelegram = $this->makeFakeServerResponse($data);
        $api = $this->getApi($this->getGuzzleHttpClient([$replyFromTelegram]), 'TOKEN', true);

        //TODO. Add raw response object to telegram response and make assertions on it.
        $user = $api->getMe();
        $this->assertEmpty($user);
    }

    /** @test */
    public function it_allows_a_file_id_to_be_used_when_using_a_method_that_involves_a_file_upload()
    {
        $data = [];
        $api = $this->getApi($this->getGuzzleHttpClient([$this->makeFakeInboundUpdate($data)]));

        $result = $api->sendDocument([
            'chat_id'  => 123456789,
            'document' => 'AwADBAADYwADO1wlBuF1ogMa7HnMAg',
        ]);

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();

        $this->assertInstanceOf(Message::class, $result);
        $this->assertStringContainsString('document=AwADBAADYwADO1wlBuF1ogMa7HnMAg', (string) $request->getBody());
    }

    /**
     * @test
     *
     * @param $type
     *
     * @dataProvider fileTypes
     * @throws TelegramSDKException
     */
    public function it_requires_all_file_uploads_except_file_id_to_be_created_with_fileInput_object($type)
    {
        $this->expectException(TelegramSDKException::class);

        $api = $this->getApi();

        $api->sendDocument([
            'chat_id'  => 123456789,
            'document' => $type,
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_param_key_used_to_upload_file_does_not_match_the_method_being_used()
    {
        $this->expectException(CouldNotUploadInputFile::class);
        $api = $this->getApi();

        //We want to send a document but the params have a voice key instead.
        $api->sendDocument([
            'chat_id' => 123456789,
            'voice'   => InputFile::create(fopen('php://input', 'r'), 'Myvoice.ogg'),
        ]);
    }

    /** @test */
    public function a_stream_not_created_from_an_actual_file_can_be_used_as_a_file_upload()
    {
        $stream = $this->streamFor('This is some text');
        $data = [];
        $api = $this->getApi($this->getGuzzleHttpClient([$this->makeFakeInboundUpdate($data)]));

        $result = $api->sendDocument([
            'chat_id'  => '123456789',
            'document' => InputFile::create($stream, 'myFile.txt'),
        ]);

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();
        $body = (string) $request->getBody();

        $this->assertInstanceOf(Message::class, $result);
        $this->assertStringContainsString('This is some text', $body);
        $this->assertStringContainsString('Content-Disposition: form-data; name="document"; filename="myFile.txt"', $body);
    }

    /**
     * @test
     */
    public function a_file_that_does_not_exist_should_throw_an_error_when_being_uploaded()
    {
        $this->expectException(CouldNotUploadInputFile::class);
        $api = $this->getApi();

        $api->sendDocument([
            'chat_id'  => '123456789',
            'document' => InputFile::create('/path/to/nonexisting/file/test.pdf'),
        ]);
    }

    /** @test */
    public function it_can_upload_a_file_properly_using_the_correct_multipart_data()
    {
        $data = [];
        $api = $this->getApi($this->getGuzzleHttpClient([$this->makeFakeInboundUpdate($data)]));

        //We can use any file input here, for testing a stream is quick and easy.
        $api->sendDocument([
            'chat_id'  => 123456789,
            'document' => InputFile::create($this->streamFor('Some text'), 'testing.txt'),
        ]);

        /** @var Request $request */
        $request = $this->getHistory()->pluck('request')->first();
        $body = (string) $request->getBody();

        $this->assertStringContainsString('Content-Disposition: form-data; name="chat_id"', $body);
        $this->assertStringContainsString('Content-Disposition: form-data; name="document"; filename="testing.txt"', $body);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertStringContainsString('multipart/form-data;', $request->getHeaderLine('Content-Type'));
    }

    /**
     * A list of files/attachments types that should be tested.
     *
     * @return array
     */
    public function fileTypes()
    {
        return [
            ['/local/path/to/file.pdf'],
            ['https://example.com/file.pdf'],
            [fopen('php://input', 'r')],
            [$this->streamFor('testData')],
        ];
    }

    /** @test */
    public function it_can_set_a_webhook_with_its_own_certificate_succcessfully()
    {
        $pubKey = '
        -----BEGIN PUBLIC KEY-----
        THISISSOMERANDOMKEYDATA
        -----END PUBLIC KEY-----';

        //Probably not the best way to attempt to create a file on a server.
        //Help appreciated.
        $fakeFile = fopen('php://temp', 'w+');
        fwrite($fakeFile, $pubKey);
        fseek($fakeFile, 0);

        //Setup the responses the fake telegram server should reply with.
        $api = $this->getApi($this->getGuzzleHttpClient([
            $this->makeFakeServerResponse(true),
            $this->makeFakeServerResponse(true),
        ]));

        // If the user uses the INPUTFILE class to send the webhook cert, the filename will override our default
        // setting of certificate.pem
        $api->setWebhook([
            'url'         => 'https://example.com',
            'certificate' => InputFile::create($this->streamFor($pubKey), 'public.key'),
        ]);

        //If the user uses just a string to the path/filename of the webhook cert.
        $api->setWebhook([
            'url'         => 'https://example.com',
            'certificate' => $fakeFile,
        ]);

        /** @var Request $request */
        $response1 = (string) $this->getHistory()->pluck('request')->get(0)->getBody();
        $response2 = (string) $this->getHistory()->pluck('request')->get(1)->getBody();

        $this->assertStringContainsString('Content-Disposition: form-data; name="certificate"; filename="public.key"', $response1);
        $this->assertStringContainsString('THISISSOMERANDOMKEYDATA', $response1);
        $this->assertStringContainsString('Content-Disposition: form-data; name="certificate"; filename="certificate.pem"', $response2);
        $this->assertStringContainsString('THISISSOMERANDOMKEYDATA', $response1);
    }

    /** @test check the webhook works */
    public function check_the_webhook_works_and_can_emmit_an_event()
    {
        $emitter = $this->prophesize(Emitter::class);

        $api = $this->getApi();
        $api->setEventEmitter($emitter->reveal());

        $update = $api->getWebhookUpdate(true);

        //We can't pass test data to the webhook because it relies on the read only stream php://input
        $this->assertEmpty($update);
        $this->assertInstanceOf(Update::class, $update);
        $emitter->emit(Argument::type(UpdateWasReceived::class))->shouldHaveBeenCalledOnce();
    }

    /** @test */
    public function it_emits_3_events_of_update_event_type()
    {
        $emitter = new Emitter();
        $listener = $this->createSpyListener();
        $emitter->addListener('*', $listener);

        $api = $this->getApi();
        $api->setEventEmitter($emitter);

        $incomeWebhookRequest = $this->createIncomeWebhookRequestInstance([
            'message' => [ // to help SDK to detect Update of "message" type and send 2nd event (with name "message")
                'text' => 'any', // to help SDK to detect message type and send 3rd event (with name "message.text")
            ],
        ]);

        $api->getWebhookUpdate(true, $incomeWebhookRequest);
        $allEvents = $listener->events;

        $this->assertArrayHasKey(UpdateEvent::NAME, $allEvents);
        $this->assertArrayHasKey('message', $allEvents);
        $this->assertArrayHasKey('message.text', $allEvents);
        $this->assertCount(1, $allEvents[UpdateEvent::NAME]);
        $this->assertCount(1, $allEvents['message']);
        $this->assertCount(1, $allEvents['message.text']);
    }

    /** @test */
    public function the_commands_handler_can_get_all_commands()
    {
        $api = $this->getApi();

        $api->addCommands($this->commandGenerator(4)->all());
        $commands = $api->getCommands();

        $this->assertCount(4, $commands);
    }

    /** @test */
    public function the_command_handler_can_use_getUpdates_to_process_updates_and_mark_updates_read()
    {
        $updateData = $this->makeFakeServerResponse([
            [
                'update_id' => 377695760,
                'message'   => [
                    'message_id' => 749,
                    'from'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                    ],
                    'chat'       => [
                        'id'         => 123456789,
                        'first_name' => 'John',
                        'last_name'  => 'Doe',
                        'username'   => 'jdoe',
                        'type'       => 'private',
                    ],
                    'date'       => 1494623093,
                    'text'       => 'Just some text',
                ],
            ],
        ]);
        $markAsReadData = $this->makeFakeServerResponse([]);
        $api = $this->getApi($this->getGuzzleHttpClient([$updateData, $markAsReadData]));

        $updates = collect($api->commandsHandler());
        $markAsReadRequest = $this->getHistory()->pluck('request')->last();

        $updates->each(function ($update) {
            $this->assertInstanceOf(Update::class, $update);
        });
        $this->assertEquals('Just some text', $updates->first()->getMessage()->text);
        $this->assertEquals('377695760', $updates->first()->updateId);
        $this->assertStringContainsString('offset=377695761&limit=1', $markAsReadRequest->getUri()->getQuery());
    }

    /** @test */
    public function the_command_handler_when_using_webhook_to_process_updates_for_commands_will_return_the_update()
    {
        $updateData = $this->makeFakeServerResponse([]);
        $api = $this->getApi($this->getGuzzleHttpClient([$updateData]));

        //We cannot mock out the php://input stream so we can't send any test data.
        // Instead, we can only just check it returns back an update object.
        $update = $api->commandsHandler(true);

        $this->assertInstanceOf(Update::class, $update);
    }

    private function streamFor($resource)
    {
        if (class_exists('\GuzzleHttp\Psr7\Utils')) {
            return \GuzzleHttp\Psr7\Utils::streamFor($resource);
        } elseif (function_exists('\GuzzleHttp\Psr7\stream_for')) {
            /** @noinspection PhpUndefinedFunctionInspection */
            return \GuzzleHttp\Psr7\stream_for($resource);
        }

        throw new \RuntimeException('Not found "streamFor" implementation');
    }

    private function createSpyListener(): \League\Event\ListenerInterface
    {
        return new class() extends AbstractListener {
            /** @var array<string, list<\League\Event\EventInterface>> */
            public $events = [];

            public function handle(EventInterface $event)
            {
                $this->events[$event->getName()][] = $event;
            }
        };
    }
}
