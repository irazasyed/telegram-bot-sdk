<?php

namespace Telegram\Bot\Objects;

/**
 * Class StickerSet.
 *
 * @link https://core.telegram.org/bots/api#stickerset
 *
 * @property string $name Sticker set name
 * @property string $title Sticker set title
 * @property string $stickerType Type of stickers in the set: regular, mask, or custom_emoji
 * @property Sticker[] $stickers List of all set stickers
 * @property PhotoSize|null $thumbnail (Optional). Sticker set thumbnail in .WEBP, .TGS, or .WEBM format
 */
class StickerSet extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{stickers: array<class-string<Sticker>>, thumbnail: string, thumb: string}
     */
    public function relations(): array
    {
        return [
            'stickers' => [Sticker::class],
            'thumbnail' => PhotoSize::class,
            'thumb' => PhotoSize::class,
        ];
    }
}
