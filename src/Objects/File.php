<?php

namespace Telegram\Bot\Objects;

/**
 * Class File.
 *
 *
 * @property string $fileId         Unique identifier for this file.
 * @property string $fileUniqueId   Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int    $fileSize       (Optional). File size, if known.
 * @property string $filePath       (Optional). File path. Use 'https://api.telegram.org/file/bot<token>/<file_path>' to get the file.
 */
class File extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
