<?php

namespace Telegram\Bot\Objects;

/**
 * Class File.
 *
 *
 * @method string   getFileId()     Unique identifier for this file.
 * @method int      getFileSize()   (Optional). File size, if known.
 * @method string   getFilePath()   (Optional). File path. Use 'https://api.telegram.org/file/bot<token>/<file_path>' to get the file.
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
