<?php

namespace Telegram\Bot\Exceptions;

/**
 * Class CouldNotUploadInputFile.
 */
class CouldNotUploadInputFile extends TelegramSDKException
{
    /**
     * @param $file
     *
     * @return CouldNotUploadInputFile
     */
    public static function fileDoesNotExistOrNotReadable($file): CouldNotUploadInputFile
    {
        return new static("File: `{$file}` does not exist or is not readable!");
    }

    /**
     * @param $path
     *
     * @return CouldNotUploadInputFile
     */
    public static function filenameNotProvided($path): CouldNotUploadInputFile
    {
        $file = is_string($path) ? $path : "the resource that you're trying to upload";

        return new static(
            "Filename not provided for {$file}. " .
            'Remote or Resource file uploads require a filename. Refer Docs for more information.'
        );
    }

    /**
     * @param $path
     *
     * @return CouldNotUploadInputFile
     */
    public static function couldNotOpenResource($path): CouldNotUploadInputFile
    {
        return new static("Failed to create InputFile entity. Unable to open resource: {$path}.");
    }

    /**
     * @param $property
     *
     * @return CouldNotUploadInputFile
     */
    public static function resourceShouldBeInputFileEntity($property): CouldNotUploadInputFile
    {
        return new static("Resource file should be uploaded using `Telegram\Bot\FileUpload\InputFile::create(\$resourceOrRemoteUrl, \$filename)` for `{$property}` property.");
    }

    /**
     * @param $inputFileField
     *
     * @return CouldNotUploadInputFile
     */
    public static function missingParam($inputFileField): CouldNotUploadInputFile
    {
        return new static("Input field [{$inputFileField}] is missing in your params. Please make sure it exists and is an `Telegram\Bot\FileUpload\InputFile` entity.");
    }
}
