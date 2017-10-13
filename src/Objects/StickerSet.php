<?php

namespace Telegram\Bot\Objects;

/**
 * Class StickerSet.
 *
 * @property string    $name               Sticker set name
 * @property string    $title              Sticker set title
 * @property bool      $containsMasks      True, if the sticker set contains masks
 * @property Sticker[] $stickers           List of all set stickers
 */
class StickerSet extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'stickers' => Sticker::class,
        ];
    }
}
