<?php

namespace Telegram\Bot\Exceptions;

/**
 * Class CouldNotUploadInputFile.
 */
class CouldNotUploadInputFile extends TelegramSDKException
{
    public static function filenameNotProvided($path)
    {
        $file = is_string($path) ? $path : 'resource file';

        return new static(
            "Filename not provided for {$file}. ".
            'Remote or Resource file uploads require a filename. Refer Docs for more information.'
        );
    }

    public static function couldNotOpenResource($path)
    {
        return new static("Failed to create InputFile entity. Unable to open resource: {$path}.");
    }

    public static function resourceShouldBeInputEntity($property)
    {
        return new static("Resource file should be uploaded using `Telegram\Bot\FileUpload\InputFile::create(\$resourceOrRemoteUrl, \$filename)` for `{$property}` property.");
    }
}
