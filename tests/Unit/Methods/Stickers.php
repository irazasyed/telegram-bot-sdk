<?php

use GuzzleHttp\Psr7\Request;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\File;
use Telegram\Bot\Objects\InputSticker;
use Telegram\Bot\Objects\Sticker;
use Telegram\Bot\Tests\Traits\GuzzleMock;

uses(GuzzleMock::class);

function stickersApi($client = null, $token = 'TELEGRAM_TOKEN'): Api
{
    return new Api($token, false, $client);
}

test('sendSticker sends HTTP URLs without treating them as local uploads', function () {
    $api = stickersApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse([])]));

    $api->sendSticker([
        'chat_id' => 123456789,
        'sticker' => 'https://example.com/sticker.webp',
        'reply_parameters' => ['message_id' => 42],
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    parse_str((string) $request->getBody(), $body);

    expect($request->getHeaderLine('Content-Type'))->toBe('application/x-www-form-urlencoded')
        ->and($body['sticker'])->toBe('https://example.com/sticker.webp')
        ->and(json_decode($body['reply_parameters'], true, 512, JSON_THROW_ON_ERROR))
        ->toBe(['message_id' => 42]);
});

test('uploadStickerFile uses the current sticker and sticker_format parameters', function () {
    $response = $this->makeFakeServerResponse([
        'file_id' => 'AwADBAADYwADO1wlBuF1ogMa7HnMAg',
        'file_unique_id' => 'unique-id',
    ]);
    $api = stickersApi($this->getGuzzleHttpClient([$response]));

    $result = $api->uploadStickerFile([
        'user_id' => 123456789,
        'sticker' => InputFile::create(streamFor('sticker contents'), 'sticker.webp'),
        'sticker_format' => 'static',
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($result)->toBeInstanceOf(File::class)
        ->and($request->getUri()->getPath())->toBe('/botTELEGRAM_TOKEN/uploadStickerFile')
        ->and($body)->toContain('name="sticker"; filename="sticker.webp"')
        ->and($body)->toContain('name="sticker_format"')
        ->and($body)->toContain('static')
        ->and($body)->not->toContain('png_sticker');
});

test('createNewStickerSet JSON encodes current InputSticker data', function () {
    $api = stickersApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));
    $stickers = [[
        'sticker' => 'AwADBAADYwADO1wlBuF1ogMa7HnMAg',
        'format' => 'static',
        'emoji_list' => ['🐼'],
        'keywords' => ['panda'],
    ]];

    expect($api->createNewStickerSet([
        'user_id' => 123456789,
        'name' => 'animals_by_example_bot',
        'title' => 'Animals',
        'stickers' => $stickers,
        'sticker_type' => 'regular',
    ]))->toBeTrue();

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    parse_str((string) $request->getBody(), $body);

    expect($request->getUri()->getPath())->toBe('/botTELEGRAM_TOKEN/createNewStickerSet')
        ->and(json_decode($body['stickers'], true, 512, JSON_THROW_ON_ERROR))->toBe($stickers)
        ->and($body)->not->toHaveKey('sticker_format');
});

test('createNewStickerSet uploads multiple nested InputSticker files with attach references', function () {
    $api = stickersApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));

    $api->createNewStickerSet([
        'user_id' => 123456789,
        'name' => 'mixed_by_example_bot',
        'title' => 'Mixed pack',
        'stickers' => [
            new InputSticker([
                'sticker' => InputFile::create(streamFor('static sticker'), 'static.webp'),
                'format' => 'static',
                'emoji_list' => ['🐼'],
            ]),
            [
                'sticker' => InputFile::create(streamFor('video sticker'), 'video.webm'),
                'format' => 'video',
                'emoji_list' => ['🎬'],
            ],
        ],
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($request->getHeaderLine('Content-Type'))->toContain('multipart/form-data;')
        ->and($body)->toContain('name="stickers"')
        ->and($body)->toContain('attach:\/\/sticker_0')
        ->and($body)->toContain('attach:\/\/sticker_1')
        ->and($body)->toContain('name="sticker_0"; filename="static.webp"')
        ->and($body)->toContain('name="sticker_1"; filename="video.webm"')
        ->and($body)->toContain('static sticker')
        ->and($body)->toContain('video sticker');
});

test('addStickerToSet uploads a nested InputSticker file', function () {
    $api = stickersApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));

    expect($api->addStickerToSet([
        'user_id' => 123456789,
        'name' => 'animals_by_example_bot',
        'sticker' => [
            'sticker' => InputFile::create(streamFor('animated sticker'), 'animated.tgs'),
            'format' => 'animated',
            'emoji_list' => ['✨'],
        ],
    ]))->toBeTrue();

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($request->getUri()->getPath())->toBe('/botTELEGRAM_TOKEN/addStickerToSet')
        ->and($body)->toContain('attach:\/\/sticker_0')
        ->and($body)->toContain('name="sticker_0"; filename="animated.tgs"');
});

test('getCustomEmojiStickers serializes identifiers and returns Sticker objects', function () {
    $response = $this->makeFakeServerResponse([
        [
            'file_id' => 'first-file-id',
            'file_unique_id' => 'first-unique-id',
            'type' => 'custom_emoji',
            'width' => 100,
            'height' => 100,
            'is_animated' => false,
            'is_video' => false,
        ],
        [
            'file_id' => 'second-file-id',
            'file_unique_id' => 'second-unique-id',
            'type' => 'custom_emoji',
            'width' => 100,
            'height' => 100,
            'is_animated' => true,
            'is_video' => false,
        ],
    ]);
    $api = stickersApi($this->getGuzzleHttpClient([$response]));

    $result = $api->getCustomEmojiStickers([
        'custom_emoji_ids' => ['first-id', 'second-id'],
    ]);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    parse_str((string) $request->getBody(), $body);

    expect($result)->toHaveCount(2)
        ->and($result[0])->toBeInstanceOf(Sticker::class)
        ->and($result[1])->toBeInstanceOf(Sticker::class)
        ->and(json_decode($body['custom_emoji_ids'], true, 512, JSON_THROW_ON_ERROR))
        ->toBe(['first-id', 'second-id']);
});

test('current sticker set management methods use their Bot API endpoints', function (
    string $method,
    array $params,
    string $endpoint,
    ?string $jsonField
) {
    $api = stickersApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));

    expect($api->{$method}($params))->toBeTrue();

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    parse_str((string) $request->getBody(), $body);

    expect($request->getUri()->getPath())->toBe('/botTELEGRAM_TOKEN/'.$endpoint);
    if ($jsonField !== null) {
        expect(json_decode($body[$jsonField], true, 512, JSON_THROW_ON_ERROR))->toBe($params[$jsonField]);
    }
})->with([
    'replace sticker' => [
        'replaceStickerInSet',
        [
            'user_id' => 123456789,
            'name' => 'animals_by_example_bot',
            'old_sticker' => 'old-file-id',
            'sticker' => ['sticker' => 'new-file-id', 'format' => 'static', 'emoji_list' => ['🐼']],
        ],
        'replaceStickerInSet',
        'sticker',
    ],
    'set emoji list' => [
        'setStickerEmojiList',
        ['sticker' => 'file-id', 'emoji_list' => ['🐼', '🎋']],
        'setStickerEmojiList',
        'emoji_list',
    ],
    'set keywords' => [
        'setStickerKeywords',
        ['sticker' => 'file-id', 'keywords' => ['panda', 'bamboo']],
        'setStickerKeywords',
        'keywords',
    ],
    'set mask position' => [
        'setStickerMaskPosition',
        ['sticker' => 'file-id', 'mask_position' => ['point' => 'eyes', 'x_shift' => 0, 'y_shift' => 0, 'scale' => 1]],
        'setStickerMaskPosition',
        'mask_position',
    ],
    'set sticker set title' => [
        'setStickerSetTitle',
        ['name' => 'animals_by_example_bot', 'title' => 'New title'],
        'setStickerSetTitle',
        null,
    ],
    'set custom emoji thumbnail' => [
        'setCustomEmojiStickerSetThumbnail',
        ['name' => 'emoji_by_example_bot', 'custom_emoji_id' => 'custom-emoji-id'],
        'setCustomEmojiStickerSetThumbnail',
        null,
    ],
    'delete sticker set' => [
        'deleteStickerSet',
        ['name' => 'animals_by_example_bot'],
        'deleteStickerSet',
        null,
    ],
]);

test('setStickerSetThumbnail uploads the current thumbnail field and format', function () {
    $api = stickersApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));

    expect($api->setStickerSetThumbnail([
        'name' => 'animals_by_example_bot',
        'user_id' => 123456789,
        'thumbnail' => InputFile::create(streamFor('thumbnail'), 'thumbnail.webp'),
        'format' => 'static',
    ]))->toBeTrue();

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($request->getUri()->getPath())->toBe('/botTELEGRAM_TOKEN/setStickerSetThumbnail')
        ->and($body)->toContain('name="thumbnail"; filename="thumbnail.webp"')
        ->and($body)->toContain('name="format"')
        ->and($body)->not->toContain('name="thumb"');
});

test('setStickerSetThumb remains a compatibility alias for the renamed endpoint', function () {
    $api = stickersApi($this->getGuzzleHttpClient([$this->makeFakeServerResponse(true)]));

    expect($api->setStickerSetThumb([
        'name' => 'animals_by_example_bot',
        'user_id' => 123456789,
        'thumb' => 'AwADBAADYwADO1wlBuF1ogMa7HnMAg',
        'format' => 'static',
    ]))->toBeTrue();

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    parse_str((string) $request->getBody(), $body);

    expect($request->getUri()->getPath())->toBe('/botTELEGRAM_TOKEN/setStickerSetThumbnail')
        ->and($body['thumbnail'])->toBe('AwADBAADYwADO1wlBuF1ogMa7HnMAg')
        ->and($body)->not->toHaveKey('thumb');
});
