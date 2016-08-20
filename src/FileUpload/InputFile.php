<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\LazyOpenStream;
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
     * @return static
     */
    public static function create($file = null, $filename = null)
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
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Return the name of the file.
     *
     * @return string
     * @throws CouldNotUploadInputFile
     */
    public function getFilename()
    {
        if (($this->isFileResourceOrStream() || $this->isFileRemote()) && !isset($this->filename)) {
            throw CouldNotUploadInputFile::filenameNotProvided($this->file);
        }

        return $this->filename ?: basename($this->file);
    }

    /**
     * Set a filename.
     *
     * @param $filename
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setFilename($filename)
    {
        if (false === $this->isStringOrNull($filename)) {
            throw new \InvalidArgumentException(
                'Filename must be a string or null'
            );
        }

        $this->filename = $filename;

        return $this;
    }

    /**
     * Get contents.
     *
     * @return InputFile
     */
    public function getContents()
    {
        return $this->contents ?: $this->open();
    }

    /**
     * Set contents of the file.
     *
     * @param string $contents
     *
     * @return $this
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Opens remote & local file.
     *
     * @return StreamInterface|resource|string
     * @throws CouldNotUploadInputFile
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
    protected function isStringOrNull($param)
    {
        return in_array(gettype($param), ['string', 'NULL']);
    }

    /**
     * Determine if it's a remote file.
     *
     * @return bool true if it's a valid URL, false otherwise.
     */
    protected function isFileRemote()
    {
        return is_string($this->file) && preg_match('/^(https?|ftp):\/\/.*/', $this->file) === 1;
    }

    /**
     * Determine if it's a resource file.
     *
     * @return bool true if it's a resource file or an instance of
     *              \Psr\Http\Message\StreamInterface, false otherwise.
     */
    protected function isFileResourceOrStream()
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
    protected function isFileLocalAndExists()
    {
        $file = @is_readable($this->file);

        if (is_null($file)) {
            return false;
        }

        if ($file) {
            return true;
        }

        throw CouldNotUploadInputFile::fileDoesNotExistOrNotReadable($this->file);
    }
}