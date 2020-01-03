<?php

namespace Telegram\Bot\Objects;

/**
 * Class Animation.
 *
 * @property string    $fileId           Unique file identifier.
 * @property string    $fileUniqueId     Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int       $width            Video width as defined by sender.
 * @property int       $height           Video height as defined by sender.
 * @property int       $duration         Duration of the video in seconds as defined by sender.
 * @property PhotoSize $thumb            (Optional). Animation thumbnail as defined by sender.
 * @property string    $fileName         (Optional). Original animation filename as defined by sender.
 * @property string    $mimeType         (Optional). MIME type of the file as defined by sender.
 * @property int       $fileSize         (Optional). File size.
 */
class Animation extends BaseObject
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
