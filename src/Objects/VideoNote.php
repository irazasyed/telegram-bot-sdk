<?php

namespace Telegram\Bot\Objects;

/**
 * @property string    $fileId         Unique identifier for this file.
 * @property string    $fileUniqueId   Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int       $length         Video width and height as defined by sender.
 * @property int       $duration       Duration of the video in seconds as defined by sender.
 * @property PhotoSize $thumb          (Optional). Video thumbnail.
 * @property int       $fileSize       (Optional). File size.
 *
 * @link https://core.telegram.org/bots/api#videonote
 */
class VideoNote extends BaseObject
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
