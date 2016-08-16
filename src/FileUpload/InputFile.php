<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7;
use Telegram\Bot\Exceptions\CouldNotUploadInputFile;

/**
 * Class InputFile.
 */
class InputFile
{
    /** @var string The path to the file on the system. */
    protected $path;

    /** @var string The filename. */
    protected $filename;

    /** @var resource The stream pointing to the file. */
    protected $stream;

    /**
     * Create a new InputFile entity from local file.
     *
     * @param string $filePath
     * @param null   $filename
     *
     * @return static
     */
    public static function create($filePath, $filename = null)
    {
        return new static($filePath, $filename);
    }

    /**
     * Creates a new InputFile entity.
     *
     * @param string $filePath
     * @param null   $filename
     *
     * @internal param string $type
     *
     */
    public function __construct($filePath, $filename = null)
    {
        $this->path = $filePath;
        $this->filename = $filename;
    }

    /**
     * Return the file path.
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->path;
    }

    /**
     * Return the name of the file.
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->filename ?: basename($this->path);
    }

    /**
     * Set a filename.
     *
     * Used with resources.
     *
     * @param $filename
     *
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get file resource contents.
     *
     * @return resource
     * @throws TelegramSDKException
     */
    public function getContents()
    {
        $this->open();

        return $this->stream;
    }

    /**
     * Opens file stream.
     *
     * @return $this
     * @throws CouldNotUploadInputFile
     */
    protected function open()
    {
        if (!$this->isFileLocal() && !isset($this->filename)) {
            throw CouldNotUploadInputFile::filenameNotProvided($this->path);
        }

        if ($this->isInvalidResourceProvided()) {
            throw CouldNotUploadInputFile::couldNotOpenResource($this->path);
        }

        if ($this->isFileLocal()) {
            $this->path = Psr7\try_fopen($this->path, 'r');
        }

        $this->stream = Psr7\stream_for($this->path);

        return $this;
    }

    /**
     * Check if provided resource is invalid.
     *
     * @return bool
     */
    protected function isInvalidResourceProvided()
    {
        return !$this->isFileResource() && !$this->isFileLocal() && !$this->isFileRemote();
    }

    /**
     * Returns true if the path to the file is readable (local).
     *
     * @return bool
     */
    protected function isFileLocal()
    {
        return is_readable($this->path);
    }

    /**
     * Returns true if the path to the file is remote.
     *
     * @return bool
     */
    protected function isFileRemote()
    {
        return preg_match('/^(https?|ftp):\/\/.*/', $this->path) === 1;
    }

    /**
     * Returns true if the given data is a resource or is set as resource.
     *
     * @return bool
     */
    protected function isFileResource()
    {
        return is_resource($this->path);
    }
}
