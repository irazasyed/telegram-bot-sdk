<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7\LazyOpenStream;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Telegram\Bot\Exceptions\CouldNotUploadInputFile;

/**
 * Class InputFile.
 */
final class InputFile
{
    /** @var string|resource|StreamInterface The contents of the file. */
    private $contents;

    /**
     * Create a new InputFile entity.
     *
     * @param  string|resource|StreamInterface|null  $file
     */
    public static function create(mixed $file = null, ?string $filename = null): self
    {
        return new self($file, $filename);
    }

    /**
     * Create a file on-the-fly using the provided contents and filename.
     *
     *
     * @return mixed
     */
    public static function createFromContents(string $contents, string $filename): InputFile
    {
        return (new self(null, $filename))->setContents($contents);
    }

    /**
     * Creates a new InputFile entity.
     *
     * @param  string|resource|StreamInterface|null  $file
     */
    public function __construct(private mixed $file = null, private ?string $filename = null)
    {
    }

    /**
     * Return the file.
     *
     * @return string|resource|StreamInterface|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set File.
     *
     * @param  string|resource|StreamInterface  $file
     */
    public function setFile(mixed $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Return the name of the file.
     *
     *
     * @throws CouldNotUploadInputFile
     */
    public function getFilename(): string
    {
        if (null === $this->filename && $this->isFileResourceOrStream()) {
            return $this->filename = $this->attemptFileNameDetection();
        }

        return $this->filename ?? basename($this->file);
    }

    /**
     * Attempts to access the metadata in the stream or resource to determine what
     * the filename should be if the user did not supply one.
     *
     *
     * @throws CouldNotUploadInputFile
     */
    private function attemptFileNameDetection(): string
    {
        if ($uri = $this->getUriMetaDataFromStream()) {
            return basename($uri);
        }

        throw CouldNotUploadInputFile::filenameNotProvided($this->file);
    }

    /**
     * Depending on if supplied Input was a resource or stream, call the appropriate
     * stream_meta command to get information required.
     *
     * Note: We can only get here if the file is a resource or a stream.
     */
    private function getUriMetaDataFromStream(): ?string
    {
        $meta = is_resource($this->file) ? stream_get_meta_data($this->file) : $this->file->getMetadata();

        return $meta['uri'] ?? null;
    }

    /**
     * Set a filename.
     *
     *
     * @throws InvalidArgumentException
     */
    public function setFilename(?string $filename): self
    {
        if (! $this->isStringOrNull($filename)) {
            throw new InvalidArgumentException(
                'Filename must be a string or null'
            );
        }

        $this->filename = $filename;

        return $this;
    }

    /**
     * Get contents.
     *
     * @return StreamInterface|resource|string
     *
     * @throws CouldNotUploadInputFile
     */
    public function getContents(): mixed
    {
        return $this->contents ?? $this->open();
    }

    /**
     * Set contents of the file.
     */
    public function setContents(string $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Opens remote & local file.
     *
     * @return StreamInterface|resource|string
     *
     * @throws CouldNotUploadInputFile
     */
    private function open()
    {
        if ($this->isFileRemote()) {
            return $this->contents = new LazyOpenStream($this->file, 'r');
        }

        if ($this->isFileLocalAndExists()) {
            return $this->contents = new LazyOpenStream($this->file, 'r');
        }

        return $this->contents = $this->file;
    }

    /**
     * Determine if given param is a string or null.
     *
     * @return bool true if it's a string or null, false otherwise.
     */
    private function isStringOrNull(mixed $param): bool
    {
        return is_string($param) || is_null($param);
    }

    /**
     * Determine if it's a remote file.
     *
     * @return bool true if it's a valid URL, false otherwise.
     */
    public function isFileRemote(): bool
    {
        return is_string($this->file) && preg_match('#^(?:https?|ftps?|sftp|ssh2)://#', $this->file) === 1;
    }

    /**
     * Determine if it's a resource file.
     *
     * @return bool true if it's a resource file or an instance of
     *              \Psr\Http\Message\StreamInterface, false otherwise.
     */
    private function isFileResourceOrStream(): bool
    {
        return is_resource($this->file) || $this->file instanceof StreamInterface;
    }

    /**
     * Determine if it's a local file and exists.
     *
     * @return bool true if the file exists and readable, false if it's not a
     *              local file. Throws exception if the file doesn't exist or
     *              is not readable otherwise.
     *
     * @throws CouldNotUploadInputFile
     */
    private function isFileLocalAndExists(): bool
    {
        if (! is_string($this->file)) {
            return false;
        }

        if (is_file($this->file) && is_readable($this->file)) {
            return true;
        }

        throw CouldNotUploadInputFile::fileDoesNotExistOrNotReadable($this->file);
    }
}
