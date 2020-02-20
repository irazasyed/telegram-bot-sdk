<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7\LazyOpenStream;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Telegram\Bot\Exceptions\CouldNotUploadInputFile;

/**
 * Class InputFile.
 */
class InputFile
{
    /** @var string|resource|StreamInterface The path to the file on the system or remote / resource. */
    protected $file;

    /** @var string|null The filename. */
    protected $filename;

    /** @var string|resource|StreamInterface The contents of the file. */
    protected $contents;

    /**
     * Create a new InputFile entity.
     *
     * @param string|resource|StreamInterface|null $file
     * @param string|null                          $filename
     *
     * @return InputFile
     */
    public static function create($file = null, $filename = null): self
    {
        return new static($file, $filename);
    }

    /**
     * Create a file on-fly using the provided contents and filename.
     *
     * @param string $contents
     * @param string $filename
     *
     * @return mixed
     */
    public static function createFromContents($contents, $filename)
    {
        return (new static(null, $filename))->setContents($contents);
    }

    /**
     * Creates a new InputFile entity.
     *
     * @param string|resource|StreamInterface|null $file
     * @param string|null                          $filename
     */
    public function __construct($file = null, $filename = null)
    {
        $this->file = $file;
        $this->filename = $filename;
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
     * @param string|resource|StreamInterface|null $file
     *
     * @return InputFile
     */
    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Return the name of the file.
     *
     * @throws CouldNotUploadInputFile
     *
     * @return string
     */
    public function getFilename(): string
    {
        if ($this->isFileResourceOrStream() && ! isset($this->filename)) {
            return $this->filename = $this->attemptFileNameDetection();
        }

        return $this->filename ?? basename($this->file);
    }

    /**
     * Attempts to access the meta data in the stream or resource to determine what
     * the filename should be if the user did not supply one.
     *
     * @throws CouldNotUploadInputFile
     *
     * @return string
     */
    protected function attemptFileNameDetection()
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
     *
     * @return string|null
     */
    protected function getUriMetaDataFromStream()
    {
        $meta = is_resource($this->file) ? stream_get_meta_data($this->file) : $this->file->getMetadata();

        return $meta['uri'] ?? null;
    }

    /**
     * Set a filename.
     *
     * @param $filename
     *
     * @throws InvalidArgumentException
     *
     * @return InputFile
     */
    public function setFilename($filename): self
    {
        if (false === $this->isStringOrNull($filename)) {
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
     * @throws CouldNotUploadInputFile
     */
    public function getContents()
    {
        return $this->contents ?? $this->open();
    }

    /**
     * Set contents of the file.
     *
     * @param string $contents
     *
     * @return InputFile
     */
    public function setContents($contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Opens remote & local file.
     *
     * @throws CouldNotUploadInputFile
     *
     * @return StreamInterface|resource|string
     */
    protected function open()
    {
        if ($this->isFileRemote() || $this->isFileLocalAndExists()) {
            return $this->contents = new LazyOpenStream($this->file, 'r');
        }

        return $this->contents = $this->file;
    }

    /**
     * Determine if given param is a string or null.
     *
     * @param mixed $param
     *
     * @return bool true if it's a string or null, false otherwise.
     */
    protected function isStringOrNull($param): bool
    {
        return in_array(gettype($param), ['string', 'NULL']);
    }

    /**
     * Determine if it's a remote file.
     *
     * @return bool true if it's a valid URL, false otherwise.
     */
    public function isFileRemote(): bool
    {
        return is_string($this->file) && preg_match('/^(https?|ftp):\/\/.*/', $this->file) === 1;
    }

    /**
     * Determine if it's a resource file.
     *
     * @return bool true if it's a resource file or an instance of
     *              \Psr\Http\Message\StreamInterface, false otherwise.
     */
    protected function isFileResourceOrStream(): bool
    {
        return is_resource($this->file) || $this->file instanceof StreamInterface;
    }

    /**
     * Determine if it's a local file and exists.
     *
     * @throws CouldNotUploadInputFile
     *
     * @return bool true if the file exists and readable, false if it's not a
     *              local file. Throws exception if the file doesn't exist or
     *              is not readable otherwise.
     */
    protected function isFileLocalAndExists(): bool
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
