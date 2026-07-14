<?php

use Illuminate\Support\Collection;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\File;
use Telegram\Bot\Objects\InputSticker;
use Telegram\Bot\Objects\PhotoSize;
use Telegram\Bot\Objects\Sticker;
use Telegram\Bot\Objects\StickerSet;

test('Sticker and StickerSet expose current Bot API fields and relations', function () {
    $set = new StickerSet([
        'name' => 'animals_by_example_bot',
        'title' => 'Animals',
        'sticker_type' => 'regular',
        'stickers' => [[
            'file_id' => 'file-id',
            'file_unique_id' => 'unique-id',
            'type' => 'regular',
            'width' => 512,
            'height' => 512,
            'is_animated' => false,
            'is_video' => true,
            'thumbnail' => ['file_id' => 'thumb-id', 'file_unique_id' => 'thumb-unique-id', 'width' => 100, 'height' => 100],
            'premium_animation' => ['file_id' => 'premium-id', 'file_unique_id' => 'premium-unique-id'],
            'needs_repainting' => true,
        ]],
        'thumbnail' => ['file_id' => 'set-thumb-id', 'file_unique_id' => 'set-thumb-unique-id', 'width' => 100, 'height' => 100],
    ]);

    expect($set->stickerType)->toBe('regular')
        ->and($set->thumbnail)->toBeInstanceOf(PhotoSize::class)
        ->and($set->stickers)->toBeInstanceOf(Collection::class)
        ->and($set->stickers[0])->toBeInstanceOf(Sticker::class)
        ->and($set->stickers[0]->type)->toBe('regular')
        ->and($set->stickers[0]->isVideo)->toBeTrue()
        ->and($set->stickers[0]->thumbnail)->toBeInstanceOf(PhotoSize::class)
        ->and($set->stickers[0]->premiumAnimation)->toBeInstanceOf(File::class)
        ->and($set->stickers[0]->needsRepainting)->toBeTrue();
});

test('InputSticker preserves string and InputFile sticker values', function () {
    $fileId = 'AwADBAADYwADO1wlBuF1ogMa7HnMAg';
    $stringSticker = new InputSticker([
        'sticker' => $fileId,
        'format' => 'static',
        'emoji_list' => ['🐼'],
        'keywords' => ['panda', 'bamboo'],
    ]);
    $inputFile = InputFile::createFromContents('sticker contents', 'sticker.webp');
    $fileSticker = new InputSticker([
        'sticker' => $inputFile,
        'format' => 'static',
        'emoji_list' => ['🐼'],
    ]);

    expect($stringSticker->sticker)->toBe($fileId)
        ->and($stringSticker->getSticker())->toBe($fileId)
        ->and($stringSticker->emojiList)->toBe(['🐼'])
        ->and($stringSticker->getEmojiList())->toBe(['🐼'])
        ->and($stringSticker->keywords)->toBe(['panda', 'bamboo'])
        ->and($stringSticker->getKeywords())->toBe(['panda', 'bamboo'])
        ->and($fileSticker->sticker)->toBe($inputFile)
        ->and($fileSticker->getSticker())->toBe($inputFile);
});
