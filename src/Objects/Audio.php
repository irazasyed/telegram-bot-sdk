<?php

namespace Telegram\Bot\Objects;

/**
 * Class Audio.
 *
 *
 * @property string    $fileId           Unique identifier for this file.
 * @property string    $fileUniqueId     Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int       $duration         Duration of the audio in seconds as defined by sender.
 * @property string    $performer        (Optional). Performer of the audio as defined by sender or by audio tags.
 * @property string    $title            (Optional). Title of the audio as defined by sender or by audio tags.
 * @property string    $mimeType         (Optional). MIME type of the file as defined by sender.
 * @property int       $fileSize         (Optional). File size.
 * @property PhotoSize $thumb            (Optional). Thumbnail of the album cover to which the music file belongs
 */
class Audio extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}
