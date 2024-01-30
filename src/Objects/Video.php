<?php

namespace Telegram\Bot\Objects;

/**
 * Class Video.
 *
 * @link https://core.telegram.org/bots/api#video
 *
 * @property string $fileId Unique identifier for this file.
 * @property string $fileUniqueId Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int $width Video width as defined by sender.
 * @property int $height Video height as defined by sender.
 * @property int $duration Duration of the video in seconds as defined by sender.
 * @property PhotoSize|null $thumb (Optional). Video thumbnail.
 * @property string|null $fileName (Optional). Original filename as defined by sender
 * @property string|null $mimeType (Optional). Mime type of a file as defined by sender.
 * @property int|null $fileSize (Optional). File size.
 */
class Video extends BaseObject
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
