<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Str;
use Telegram\Bot\FileUpload\InputFile;

/**
 * Describes a sticker to be added to a sticker set.
 *
 * An InputFile can be used for the sticker property when this object is passed
 * to createNewStickerSet(), addStickerToSet(), or replaceStickerInSet().
 *
 * @link https://core.telegram.org/bots/api#inputsticker
 *
 * @property string|InputFile $sticker Sticker file_id, HTTP URL, attach:// reference, or file upload.
 * @property string $format Sticker format: static, animated, or video.
 * @property string[] $emojiList List of 1-20 associated emoji.
 * @property MaskPosition|null $maskPosition (Optional). Position for a mask sticker.
 * @property string[]|null $keywords (Optional). Up to 20 search keywords with a total length up to 64 characters.
 */
class InputSticker extends BaseObject
{
    /**
     * The sticker input is a scalar or InputFile, not a Sticker relation.
     */
    protected function getPropertyValue(string $property, mixed $default = null): mixed
    {
        if (Str::snake($property) === 'sticker') {
            return $this->items['sticker'] ?? value($default);
        }

        return parent::getPropertyValue($property, $default);
    }

    /**
     * {@inheritdoc}
     *
     * @return array{mask_position: string}
     */
    public function relations(): array
    {
        return [
            'mask_position' => MaskPosition::class,
        ];
    }
}
