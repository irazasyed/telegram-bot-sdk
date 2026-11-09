<?php

use GuzzleHttp\Psr7\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Tests\Traits\GuzzleMock;

uses(GuzzleMock::class);

function messageApi($client = null, $token = 'TELEGRAM_TOKEN'): Api
{
    return new Api($token, false, $client);
}

test('deleteMessageReaction sends request to correct endpoint', function (): void {
    $api = messageApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $result = $api->deleteMessageReaction([
        'chat_id' => 123456789,
        'message_id' => 42,
        'user_id' => 987654321,
        'actor_chat_id' => 555666777,
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();

    expect($request->getUri()->getPath())->toEqual('/botTELEGRAM_TOKEN/deleteMessageReaction')
        ->and($result)->toBeTrue();
});

test('deleteMessageReaction sends all parameters', function (): void {
    $api = messageApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $api->deleteMessageReaction([
        'chat_id' => 123456789,
        'message_id' => 42,
        'user_id' => 987654321,
        'actor_chat_id' => 555666777,
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($body)->toContain('chat_id=123456789')
        ->and($body)->toContain('message_id=42')
        ->and($body)->toContain('user_id=987654321')
        ->and($body)->toContain('actor_chat_id=555666777');
});

test('setMessageReaction defaults omitted reaction to an empty list', function (): void {
    $api = messageApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $result = $api->setMessageReaction([
        'chat_id' => 123456789,
        'message_id' => 42,
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($body)->toContain('reaction='.urlencode('[]'))
        ->and($result)->toBeTrue();
});

test('setMessageReaction wraps a single reaction into a list', function (): void {
    $api = messageApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $api->setMessageReaction([
        'chat_id' => 123456789,
        'message_id' => 42,
        'reaction' => ['type' => 'emoji', 'emoji' => '👍'],
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    $expected = json_encode([['type' => 'emoji', 'emoji' => '👍']]);
    expect($body)->toContain('reaction='.urlencode($expected));
});

test('setMessageReaction re-indexes a gapped list of reactions', function (): void {
    $api = messageApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $api->setMessageReaction([
        'chat_id' => 123456789,
        'message_id' => 42,
        'reaction' => [2 => ['type' => 'emoji', 'emoji' => '👍']],
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    parse_str((string) $request->getBody(), $body);

    expect(json_decode($body['reaction'], true, 512, JSON_THROW_ON_ERROR))
        ->toBe([['type' => 'emoji', 'emoji' => '👍']]);
});

test('setMessageReaction wraps a non-array reaction', function (): void {
    $api = messageApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $api->setMessageReaction([
        'chat_id' => 123456789,
        'message_id' => 42,
        'reaction' => '👍',
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    parse_str((string) $request->getBody(), $body);

    expect(json_decode($body['reaction'], true, 512, JSON_THROW_ON_ERROR))->toBe(['👍']);
});

test('deleteAllMessageReactions sends request to correct endpoint', function (): void {
    $api = messageApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $result = $api->deleteAllMessageReactions([
        'chat_id' => 123456789,
        'user_id' => 987654321,
        'actor_chat_id' => 555666777,
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();

    expect($request->getUri()->getPath())->toEqual('/botTELEGRAM_TOKEN/deleteAllMessageReactions')
        ->and($result)->toBeTrue();
});

test('deleteAllMessageReactions sends all parameters', function (): void {
    $api = messageApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $api->deleteAllMessageReactions([
        'chat_id' => 123456789,
        'user_id' => 987654321,
        'actor_chat_id' => 555666777,
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($body)->toContain('chat_id=123456789')
        ->and($body)->toContain('user_id=987654321')
        ->and($body)->toContain('actor_chat_id=555666777');
});
