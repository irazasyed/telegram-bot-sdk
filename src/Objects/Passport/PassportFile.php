<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property string $fileId              Unique identifier for this file
 * @property int    $fileSize            File size
 * @property int    $fileDate            Unix time when the file was uploaded
 *
 * @link https://core.telegram.org/bots/api#passportfile
 */
class PassportFile extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
        ];
    }
}
