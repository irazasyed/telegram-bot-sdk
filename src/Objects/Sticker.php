<?php

namespace Telegram\Bot\Objects;

/**
 * Class Sticker.
 *
 * @link https://core.telegram.org/bots/api#sticker
 *
 * @property string $fileId Unique identifier for this file.
 * @property string $fileUniqueId Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property string $type Type of the sticker: regular, mask, or custom_emoji.
 * @property int $width Sticker width.
 * @property int $height Sticker height.
 * @property bool $isAnimated True, if the sticker is animated.
 * @property bool $isVideo True, if the sticker is a video sticker.
 * @property PhotoSize|null $thumbnail (Optional). Sticker thumbnail in .WEBP or .JPG format.
 * @property string|null $emoji (Optional). Emoji associated with the sticker
 * @property string|null $setName (Optional). Name of the sticker set to which the sticker belongs
 * @property File|null $premiumAnimation (Optional). Premium animation for a premium regular sticker.
 * @property MaskPosition|null $maskPosition (Optional). For mask stickers, the position where the mask should be placed
 * @property string|null $customEmojiId (Optional). Unique identifier of a custom emoji sticker.
 * @property bool|null $needsRepainting (Optional). Whether the sticker must be repainted based on context.
 * @property int|null $fileSize (Optional). File size.
 */
class Sticker extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{thumbnail: string, premium_animation: string, mask_position: string, thumb: string}
     */
    public function relations(): array
    {
        return [
            'thumbnail' => PhotoSize::class,
            'premium_animation' => File::class,
            'thumb' => PhotoSize::class,
            'mask_position' => MaskPosition::class,
        ];
    }
}
