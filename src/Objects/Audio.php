<?php

namespace Telegram\Bot\Objects;

/**
 * Class Audio.
 *
 *
 * @property string   $fileId     Unique identifier for this file.
 * @property int      $duration   Duration of the audio in seconds as defined by sender.
 * @property string   $performer  (Optional). Performer of the audio as defined by sender or by audio tags.
 * @property string   $title      (Optional). Title of the audio as defined by sender or by audio tags.
 * @property string   $mimeType   (Optional). MIME type of the file as defined by sender.
 * @property int      $fileSize   (Optional). File size.
 */
class Audio extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
