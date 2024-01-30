<?php

namespace Telegram\Bot\Objects;

/**
 * Class StickerSet.
 *
 * @link https://core.telegram.org/bots/api#stickerset
 *
 * @property string $name Sticker set name
 * @property string $title Sticker set title
 * @property bool $isAnimated True, if the sticker set contains animated stickers
 * @property bool $containsMasks True, if the sticker set contains masks
 * @property Sticker[] $stickers List of all set stickers
 * @property PhotoSize|null $thumb (Optional). Sticker set thumbnail in the .WEBP or .TGS format
 */
class StickerSet extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{stickers: array<class-string<Sticker>>, thumb: string}
     */
    public function relations(): array
    {
        return [
            'stickers' => [Sticker::class],
            'thumb' => PhotoSize::class,
        ];
    }
}
