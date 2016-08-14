<?php

namespace Telegram\Bot\Objects;

/**
 * Class Voice.
 *
 *
 * @property string   $fileId     Unique identifier for this file.
 * @property int      $duration   Duration of the audio in seconds as defined by sender.
 * @property string   $mimeType   (Optional). MIME type of the file as defined by sender.
 * @property int      $fileSize   (Optional). File size.
 */
class Voice extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
