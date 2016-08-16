<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7;
use Telegram\Bot\Exceptions\TelegramSDKException;

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

    /** @var bool Is Resource. */
    protected $is_resource = false;

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
     * Create a new InputFile entity from remote url.
     *
     * @param string $url
     * @param string $filename
     *
     * @return mixed
     */
    public static function createFromRemote($url, $filename)
    {
        return new static($url, $filename);
    }

    /**
     * Create a new InputFile entity from resource.
     *
     * @param resource $resource
     * @param string   $filename
     *
     * @return static
     */
    public static function createFromResource($resource, $filename)
    {
        return new static($resource, $filename, true);
    }

    /**
     * Creates a new InputFile entity.
     *
     * @param string $filePath
     * @param null   $filename
     * @param bool   $is_resource
     *
     * @internal param string $type
     *
     */
    public function __construct($filePath, $filename = null, $is_resource = false)
    {
        $this->path = $filePath;
        $this->filename = $filename;
        $this->is_resource = $is_resource;
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
     * @throws TelegramSDKException
     */
    public function getFileName()
    {
        if ($this->isFileResource() || $this->isFileRemote()) {
            if (!isset($this->filename)) {
                throw new TelegramSDKException('Filename Not Set. Remote or Resource file uploads require a filename.');
            }

            return $this->filename;
        }

        return basename($this->path);
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

        if (!$this->stream) {
            throw new TelegramSDKException("Failed to create InputFile entity. Unable to open resource: {$this->path}.");
        }

        return $this->stream;
    }

    /**
     * Opens file stream.
     *
     * @throws TelegramSDKException
     *
     * @return resource
     */
    protected function open()
    {
        if ($this->isFileResource()) {
            $this->stream = Psr7\stream_for($this->path);

            return $this;
        }

        if (!$this->isFileRemote() && !$this->isFileLocal()) {
            throw new TelegramSDKException("Failed to create InputFile entity. Unable to open resource: {$this->path}.");
        }

        $this->stream = Psr7\try_fopen($this->path, 'r');

        return $this;
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
        return is_resource($this->path) || $this->is_resource;
    }
}
