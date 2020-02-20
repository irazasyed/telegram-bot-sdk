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
    public static function fileDoesNotExistOrNotReadable($file): self
    {
        return new static("File: `{$file}` does not exist or is not readable!");
    }

    /**
     * @param $path
     *
     * @return CouldNotUploadInputFile
     */
    public static function filenameNotProvided($path): self
    {
        $file = is_string($path) ? $path : "the resource that you're trying to upload";

        return new static(
            "Filename not provided for {$file}. ".
            'Remote or Resource file uploads require a filename. Refer Docs for more information.'
        );
    }

    /**
     * @param $path
     *
     * @return CouldNotUploadInputFile
     */
    public static function couldNotOpenResource($path): self
    {
        return new static("Failed to create InputFile entity. Unable to open resource: {$path}.");
    }

    /**
     * @param $property
     *
     * @return CouldNotUploadInputFile
     */
    public static function inputFileParameterShouldBeInputFileEntity($property): self
    {
        return new static("A path to local file, a URL, or a file resource should be uploaded using `Telegram\Bot\FileUpload\InputFile::create(\$pathOrUrlOrResource, \$filename)` for `{$property}` property. Please view docs for example.");
    }

    /**
     * @param $inputFileField
     *
     * @return CouldNotUploadInputFile
     */
    public static function missingParam($inputFileField): self
    {
        return new static("Input field [{$inputFileField}] is missing in your params. Please make sure it exists and is an `Telegram\Bot\FileUpload\InputFile` entity.");
    }
}
