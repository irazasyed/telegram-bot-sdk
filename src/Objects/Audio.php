<?php

namespace Telegram\Bot\Objects;

/**
 * Class Audio.
 *
 * @link https://core.telegram.org/bots/api#audio
 *
 * @property string $fileId Unique identifier for this file.
 * @property string $fileUniqueId Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int $duration Duration of the audio in seconds as defined by sender.
 * @property string|null $performer (Optional). Performer of the audio as defined by sender or by audio tags.
 * @property string|null $title (Optional). Title of the audio as defined by sender or by audio tags.
 * @property string|null $mimeType (Optional). MIME type of the file as defined by sender.
 * @property int|null $fileSize (Optional). File size.
 * @property PhotoSize|null $thumb (Optional). Thumbnail of the album cover to which the music file belongs
 */
class Audio extends BaseObject
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
