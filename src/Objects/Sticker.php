<?php

namespace Telegram\Bot\Objects;

/**
 * Class Sticker.
 *
 * @link https://core.telegram.org/bots/api#sticker
 *
 * @property string            $fileId              Unique identifier for this file.
 * @property string            $fileUniqueId        Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int               $width               Sticker width.
 * @property int               $height              Sticker height.
 * @property bool              $isAnimated          True, if the sticker is animated.
 * @property PhotoSize|null    $thumb               (Optional). Sticker thumbnail in .webp or .jpg format.
 * @property string|null       $emoji               (Optional). Emoji associated with the sticker
 * @property string|null       $setName             (Optional). Name of the sticker set to which the sticker belongs
 * @property MaskPosition|null $maskPosition        (Optional). For mask stickers, the position where the mask should be placed
 * @property int|null          $fileSize            (Optional). File size.
 */
class Sticker extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{thumb: string, mask_position: string}
     */
    public function relations(): array
    {
        return [
            'thumb' => PhotoSize::class,
            'mask_position' => MaskPosition::class,
        ];
    }
}
