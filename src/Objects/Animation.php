<?php

namespace Telegram\Bot\Objects;

/**
 * Class Animation.
 *
 * @property string      $fileId   Unique file identifier.
 * @property PhotoSize[] $thumb    (Optional). Animation thumbnail as defined by sender.
 * @property string      $fileName (Optional). Original animation filename as defined by sender.
 * @property string      $mimeType (Optional). MIME type of the file as defined by sender.
 * @property int         $fileSize (Optional). File size.
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
