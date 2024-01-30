<?php

namespace Telegram\Bot\Objects;

/**
 * @link https://core.telegram.org/bots/api#videonote
 *
 * @property string $fileId Unique identifier for this file.
 * @property string $fileUniqueId Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int $length Video width and height as defined by sender.
 * @property int $duration Duration of the video in seconds as defined by sender.
 * @property PhotoSize|null $thumb (Optional). Video thumbnail.
 * @property int|null $fileSize (Optional). File size.
 */
class VideoNote extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{thumb: string}
     */
    public function relations(): array
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}
