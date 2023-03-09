<?php

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Utils;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Http\Message\StreamInterface;
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
use Telegram\Bot\Objects\WebhookInfo;
use Telegram\Bot\TelegramResponse;
use Telegram\Bot\Tests\Traits\CommandGenerator;
use Telegram\Bot\Tests\Traits\GuzzleMock;

uses(ProphecyTrait::class, GuzzleMock::class, CommandGenerator::class);

/**
 * @var array<string, bool|int|string>
 */
const PARAMS = [
    'chat_id' => 12_345_678,
    'text' => 'lorem ipsum',
    'disable_web_page_preview' => true,
    'disable_notification' => false,
    'reply_to_message_id' => 99_999_999,
];

/**
 * @var array<string, array<string, array<string, int|string>|int|string>|int>[]
 */
const DATA1 = [
    [
        'update_id' => 377695760,
        'message' => [
            'message_id' => 749,
            'from' => [
                'id' => 123_456_789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
            ],
            'chat' => [
                'id' => 123_456_789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
                'type' => 'private',
            ],
            'date' => 1494623093,
            'text' => 'Test1',
        ],
    ],
    [
        'update_id' => 377695761,
        'message' => [
            'message_id' => 750,
            'from' => [
                'id' => 123456789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
            ],
            'chat' => [
                'id' => 123456789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
                'type' => 'private',
            ],
            'date' => 149462395,
            'text' => 'Test2',
        ],
    ],
];

/**
 * @var array<string, array<string, array<string, int|string>|int|string>|int>[]
 */
const DATA2 = [
    [
        'update_id' => 377695762,
        'message' => [
            'message_id' => 751,
            'from' => [
                'id' => 123456789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
            ],
            'chat' => [
                'id' => 123456789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
                'type' => 'private',
            ],
            'date' => 1494623093,
            'text' => 'Test3',
        ],
    ],
    [
        'update_id' => 377695763,
        'message' => [
            'message_id' => 752,
            'from' => [
                'id' => 123456789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
            ],
            'chat' => [
                'id' => 123456789,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'jdoe',
                'type' => 'private',
            ],
            'date' => 1494623095,
            'text' => 'Test4',
        ],
    ],
];

/**
 * @var string
 */
const PUB_KEY = '
        -----BEGIN PUBLIC KEY-----
        THISISSOMERANDOMKEYDATA
        -----END PUBLIC KEY-----';

afterEach(function () {
    // Prevent previous commands added to the bus lingering between
    // tests.
    CommandBus::destroy();
});

function api($client = null, $token = 'TELEGRAM_TOKEN', bool $async = false): Api
{
    return new Api($token, $async, $client);
}

/** Create Request to emulate income Request from Telegram. */
function createIncomeWebhookRequestInstance(array $updateData): Request
{
    return new Request('POST', 'any', [], json_encode($updateData, JSON_THROW_ON_ERROR));
}

it('checks the default http client is guzzle if not specified', function () {
    $api = api();
    $client = $api->getClient()->getHttpClientHandler();

    expect($client)->toBeInstanceOf(GuzzleHttpClient::class);
});

test('a guzzle client with a mock queue can be used without error', function () {
    $api = api($this->getGuzzleHttpClient());

    expect($api)->toBeInstanceOf(Api::class);
});

test('a normal guzzle client with no mock queue can be used without error', function () {
    $api = api();

    expect($api)->toBeInstanceOf(Api::class);
});

it('returns an empty array if there are no updates', function () {
    $data = [];
    $fakeResponse = $this->makeFakeServerResponse($data);

    $api = api($this->getGuzzleHttpClient([$fakeResponse]));
    $result = $api->getUpdates();

    expect($result)->toBeArray()
        ->and($result)->toBeEmpty();
});

test('the correct bot url is used when a request is made', function () {
    $data = [];
    $fakeResponse = $this->makeFakeServerResponse($data);

    $api = api($this->getGuzzleHttpClient([$fakeResponse]), 'Special_Bot_Token');
    $api->getMe();

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();

    expect($request->getUri()->getScheme())->toEqual('https')
        ->and($request->getUri()->getHost())->toEqual('api.telegram.org')
        ->and($request->getUri()->getPath())->toEqual('/botSpecial_Bot_Token/getMe');
});

test('the correct request query string is created when a get method has parameters', function () {
    $data = [];
    $fakeResponse = $this->makeFakeServerResponse($data);

    $api = api($this->getGuzzleHttpClient([$fakeResponse]), 'Special_Bot_Token');
    $api->getChatMember([
        'chat_id' => 123_456_789,
        'user_id' => 888_888_888,
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();

    expect($request->getBody())->toEqual('') //'The get request had a body when it should be blank.'
    ->and($request->getUri()->getScheme())->toEqual('https')
        ->and($request->getUri()->getHost())->toEqual('api.telegram.org')
        ->and($request->getUri()->getPath())->toEqual('/botSpecial_Bot_Token/getChatMember')
        ->and($request->getUri()->getQuery())->toEqual('chat_id=123456789&user_id=888888888');
});

test('the correct request body data is created when a post method has parameters', function () {
    $data = [];
    $fakeResponse = $this->makeFakeServerResponse($data);

    $api = api($this->getGuzzleHttpClient([$fakeResponse]), 'Special_Bot_Token');
    $api->sendMessage(PARAMS);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();

    expect($request->getBody())->toBeInstanceOf(Stream::class)
        ->and((string) $request->getBody())->toEqual(http_build_query(PARAMS))
        ->and($request->getUri()->getScheme())->toEqual('https')
        ->and($request->getUri()->getHost())->toEqual('api.telegram.org')
        ->and($request->getUri()->getPath())->toEqual('/botSpecial_Bot_Token/sendMessage')
        ->and($request->getUri()->getQuery())->toEqual('');
});

it('returns decoded update objects when updates are available', function () {
    $replyFromTelegram1 = $this->makeFakeServerResponse(DATA1);
    $replyFromTelegram2 = $this->makeFakeServerResponse(DATA2);

    $api = api($this->getGuzzleHttpClient([$replyFromTelegram1, $replyFromTelegram2]));
    $firstUpdates = $api->getUpdates();
    $secondUpdates = $api->getUpdates();

    expect($firstUpdates)->toHaveCount(2)
        ->and($firstUpdates[0]->updateId)->toEqual('377695760')
        ->and($firstUpdates[0]->message->text)->toEqual('Test1')
        ->and($firstUpdates[1]->updateId)->toEqual('377695761')
        ->and($firstUpdates[1]->message->text)->toEqual('Test2')
        ->and($secondUpdates)->toHaveCount(2)
        ->and($secondUpdates[0]->updateId)->toEqual('377695762')
        ->and($secondUpdates[0]->message->text)->toEqual('Test3')
        ->and($secondUpdates[1]->updateId)->toEqual('377695763')
        ->and($secondUpdates[1]->message->text)->toEqual('Test4');
});

it('throws an exception if a method called does not exist')
    ->tap(fn () => api()->badMethod())
    ->throws(BadMethodCallException::class);

it('checks the last response property gets populated after a request', function () {
    $data = [
        [
            'update_id' => 377_695_760,
        ],
    ];
    $replyFromTelegram = $this->makeFakeServerResponse($data);
    $api = api($this->getGuzzleHttpClient([$replyFromTelegram]));

    expect($api->getLastResponse())->toBeEmpty();

    $api->getUpdates();

    $lastResponse = $api->getLastResponse();
    expect($lastResponse)->not->toBeEmpty();

    if ($lastResponse !== null) {
        expect($lastResponse->getDecodedBody()['result'][0]['update_id'])->toEqual('377695760')
            ->and($lastResponse)->toBeInstanceOf(TelegramResponse::class);
    }
});

it('throws an exception if the api response is not ok', function () {
    $badUpdateReply = $this->makeFakeServerErrorResponse(123, 'BadResponse Test');
    $api = api($this->getGuzzleHttpClient([$badUpdateReply]));

    $api->getUpdates();
})->throws(TelegramResponseException::class, 'BadResponse Test');

it('throws exception if invalid chat action is sent')
    ->tap(fn () => api()->sendChatAction(['action' => 'zzz']))
    ->throws(TelegramSDKException::class);

it('can use async promises to send requests', function () {
    $data = [
        [
            'update_id' => 377695763,
        ],
    ];
    $replyFromTelegram = $this->makeFakeServerResponse($data);
    $api = api($this->getGuzzleHttpClient([$replyFromTelegram]), 'TOKEN', true);

    // TODO: Add raw response object to telegram response and make assertions on it.
    $user = $api->getMe();
    expect($user)->toBeEmpty();
});

it('allows a file id to be used when using a method that involves a file upload', function () {
    $data = [];
    $api = api($this->getGuzzleHttpClient([$this->makeFakeInboundUpdate($data)]));

    $result = $api->sendDocument([
        'chat_id' => 123456789,
        'document' => 'AwADBAADYwADO1wlBuF1ogMa7HnMAg',
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();

    expect($result)->toBeInstanceOf(Message::class);
    $this->assertStringContainsString('document=AwADBAADYwADO1wlBuF1ogMa7HnMAg', (string) $request->getBody());
});

it('requires all file uploads except file id to be created with file input object')
    ->tap(fn ($type) => api()->sendDocument(['chat_id' => 123456789, 'document' => $type]))
    ->with([
        ['/local/path/to/file.pdf'],
        ['https://example.com/file.pdf'],
        [fopen('php://input', 'rb')],
        [streamFor('testData')],
    ])
    ->throws(TelegramSDKException::class);

it('throws an exception if the param key used to upload file does not match the method being used', function () {
    //We want to send a document but the params have a voice key instead.
    api()->sendDocument([
        'chat_id' => 123456789,
        'voice' => InputFile::create(fopen('php://input', 'rb'), 'Myvoice.ogg'),
    ]);
})->throws(CouldNotUploadInputFile::class);

test('a stream not created from an actual file can be used as a file upload', function () {
    $stream = streamFor('This is some text');
    $data = [];
    $api = api($this->getGuzzleHttpClient([$this->makeFakeInboundUpdate($data)]));

    $result = $api->sendDocument([
        'chat_id' => '123456789',
        'document' => InputFile::create($stream, 'myFile.txt'),
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($result)->toBeInstanceOf(Message::class);
    $this->assertStringContainsString('This is some text', $body);
    $this->assertStringContainsString('Content-Disposition: form-data; name="document"; filename="myFile.txt"', $body);
});

test('a file that does not exist should throw an error when being uploaded', function () {
    api()->sendDocument([
        'chat_id' => '123456789',
        'document' => InputFile::create('/path/to/nonexisting/file/test.pdf'),
    ]);
})->throws(CouldNotUploadInputFile::class);

it('can upload a file properly using the correct multipart data', function () {
    $data = [];
    $api = api($this->getGuzzleHttpClient([$this->makeFakeInboundUpdate($data)]));

    //We can use any file input here, for testing a stream is quick and easy.
    $api->sendDocument([
        'chat_id' => 123_456_789,
        'document' => InputFile::create(streamFor('Some text'), 'testing.txt'),
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    $this->assertStringContainsString('Content-Disposition: form-data; name="chat_id"', $body);
    $this->assertStringContainsString('Content-Disposition: form-data; name="document"; filename="testing.txt"', $body);
    expect($request->getMethod())->toEqual('POST');
    $this->assertStringContainsString('multipart/form-data;', $request->getHeaderLine('Content-Type'));
});

it('can set a webhook with its own certificate successfully', function () {
    //Probably not the best way to attempt to create a file on a server.
    //Help appreciated.
    $fakeFile = fopen('php://temp', 'wb+');
    fwrite($fakeFile, PUB_KEY);
    fseek($fakeFile, 0);

    // Set up the responses the fake telegram server should reply with.
    $api = api($this->getGuzzleHttpClient([
        $this->makeFakeServerResponse(true),
        $this->makeFakeServerResponse(true),
    ]));

    // If the user uses the INPUTFILE class to send the webhook cert, the filename will override our default
    // setting of certificate.pem
    $api->setWebhook([
        'url' => 'https://example.com',
        'certificate' => InputFile::create(streamFor(PUB_KEY), 'public.key'),
    ]);

    //If the user uses just a string to the path/filename of the webhook cert.
    $api->setWebhook([
        'url' => 'https://example.com',
        'certificate' => $fakeFile,
    ]);

    $response1 = (string) $this->getHistory()->pluck('request')->get(0)->getBody();
    $response2 = (string) $this->getHistory()->pluck('request')->get(1)->getBody();

    $this->assertStringContainsString('Content-Disposition: form-data; name="certificate"; filename="public.key"', $response1);
    $this->assertStringContainsString('THISISSOMERANDOMKEYDATA', $response1);
    $this->assertStringContainsString('Content-Disposition: form-data; name="certificate"; filename="certificate.pem"', $response2);
    $this->assertStringContainsString('THISISSOMERANDOMKEYDATA', $response1);
});

test('check the webhook works and can emmit an event', function () {
    $api = api();
    $listener = createSpyListener();

    $api->eventDispatcher()->subscribeTo(UpdateWasReceived::class, $listener);

    $incomeWebhookRequest = createIncomeWebhookRequestInstance([]);

    $update = $api->getWebhookUpdate(true, $incomeWebhookRequest);

    expect($update)->toBeEmpty()
        ->and($listener->numberOfTimeCalled())->toBeOne();
});

it('dispatches 3 events of update event type', function () {
    $api = api();
    $listener = createSpyListener();

    $api->eventDispatcher()->subscribeTo(UpdateEvent::class, $listener);

    $incomeWebhookRequest = createIncomeWebhookRequestInstance([
        'message' => [ // to help SDK to detect Update of "message" type and send 2nd event (with name "message")
            'text' => 'any', // to help SDK to detect message type and send 3rd event (with name "message.text")
        ],
    ]);

    $api->getWebhookUpdate(true, $incomeWebhookRequest);

    $allEvents = $listener->events;

    expect($listener->numberOfTimeCalled())->toBe(3)
        ->and($allEvents)->toHaveKey(UpdateEvent::NAME)
        ->and($allEvents)->toHaveKey('message')
        ->and($allEvents)->toHaveKey('message.text')
        ->and($allEvents[UpdateEvent::NAME])->toHaveCount(1)
        ->and($allEvents['message'])->toHaveCount(1)
        ->and($allEvents['message.text'])->toHaveCount(1);
});

it('can get the webhook info', function () {
    $api = api($this->getGuzzleHttpClient([
        $this->makeFakeServerResponse([
            'url' => 'https://example.com',
            'has_custom_certificate' => true,
            'pending_update_count' => 0,
            'last_error_date' => 0,
            'last_error_message' => '',
            'max_connections' => 40,
        ]),
    ]));

    $response = $api->getWebhookInfo();

    expect($response)->toBeInstanceOf(WebhookInfo::class)
        ->and($response->url)->toEqual('https://example.com')
        ->and($response->hasCustomCertificate)->toBeTrue()
        ->and($response->pendingUpdateCount)->toEqual(0)
        ->and($response->lastErrorDate)->toEqual(0)
        ->and($response->lastErrorMessage)->toEqual('')
        ->and($response->maxConnections)->toEqual(40);
});

test('the commands handler can get all commands', function () {
    $api = api();

    $api->addCommands($this->commandGenerator(4)->all());

    $commands = $api->getCommands();

    expect($commands)->toHaveCount(4);
});

test('the command handler can use get updates to process updates and mark updates read', function () {
    $updateData = $this->makeFakeServerResponse([
        [
            'update_id' => 377695760,
            'message' => [
                'message_id' => 749,
                'from' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                ],
                'chat' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                    'type' => 'private',
                ],
                'date' => 1494623093,
                'text' => 'Just some text',
            ],
        ],
    ]);
    $markAsReadData = $this->makeFakeServerResponse([]);
    $api = api($this->getGuzzleHttpClient([$updateData, $markAsReadData]));

    $updates = collect($api->commandsHandler());
    $markAsReadRequest = $this->getHistory()->pluck('request')->last();

    $updates->each(function ($update): void {
        expect($update)->toBeInstanceOf(Update::class);
    });

    expect($updates->first()->getMessage()->text)->toEqual('Just some text')
        ->and($updates->first()->updateId)->toEqual('377695760');

    $this->assertStringContainsString('offset=377695761&limit=1', $markAsReadRequest->getUri()->getQuery());
});

test('the command handler when using webhook to process updates for commands will return the update', function () {
    $updateData = $this->makeFakeServerResponse([]);
    $api = api($this->getGuzzleHttpClient([$updateData]));

    // We cannot mock out the php://input stream, so we can't send any test data.
    // Instead, we can only just check it returns back an update object.
    $update = $api->commandsHandler(true);

    expect($update)->toBeInstanceOf(Update::class);
});

function streamFor($resource): StreamInterface
{
    if (class_exists(Utils::class)) {
        return Utils::streamFor($resource);
    }

    throw new RuntimeException('Not found "streamFor" implementation');
}

function createSpyListener()
{
    return new class implements \League\Event\Listener
    {
        public array $events = [];

        private ?object $calledWith = null;

        private int $timesCalled = 0;

        public function __invoke(object $event): void
        {
            $this->timesCalled++;
            $this->calledWith = $event;
            $this->events[$event->eventName()][] = $event;
        }

        public function numberOfTimeCalled(): int
        {
            return $this->timesCalled;
        }

        public function wasCalledWith(object $event): bool
        {
            return $event === $this->calledWith;
        }
    };
}
