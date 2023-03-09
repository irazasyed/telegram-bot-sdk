<?php

namespace Telegram\Bot\Exceptions;

use Telegram\Bot\FileUpload\InputFile;

/**
 * Class CouldNotUploadInputFile.
 */
final class CouldNotUploadInputFile extends TelegramSDKException
{
    public static function fileDoesNotExistOrNotReadable($file): self
    {
        return new self(sprintf('File: `%s` does not exist or is not readable!', $file));
    }

    public static function filenameNotProvided($path): self
    {
        $file = is_string($path) ? $path : "the resource that you're trying to upload";

        return new self(
            sprintf('Filename not provided for %s. ', $file).
            'Remote or Resource file uploads require a filename. Refer Docs for more information.'
        );
    }

    public static function couldNotOpenResource($path): self
    {
        return new self(sprintf('Failed to create InputFile entity. Unable to open resource: %s.', $path));
    }

    public static function inputFileParameterShouldBeInputFileEntity($property): self
    {
        return new self(sprintf('A path to local file, a URL, or a file resource should be uploaded using `'.InputFile::class.'::create($pathOrUrlOrResource, $filename)` for `%s` property. Please view docs for example.', $property));
    }

    public static function missingParam($inputFileField): self
    {
        return new self(sprintf('Input field [%s] is missing in your params. Please make sure it exists and is an `Telegram\Bot\FileUpload\InputFile` entity.', $inputFileField));
    }
}
