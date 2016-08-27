<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\FileUpload\InputFile;

/**
 * Validator
 */
trait Validator
{
    /**
     * Determine given param in params array is a file id.
     *
     * @param $param
     * @param $params
     *
     * @return bool
     */
    protected function hasFileId($param, array $params)
    {
        return array_key_exists($param, $params) && $this->isFileId($params[$param]);
    }

    /**
     * Determine if given contents are an instance of InputFile.
     *
     * @param $contents
     *
     * @return bool
     */
    protected function isInputFile($contents)
    {
        return $contents instanceof InputFile;
    }

    /**
     * Determine the given string is a file id.
     *
     * @param  string $value
     *
     * @return bool
     */
    protected function isFileId($value)
    {
        if (!is_string($value)) {
            return false;
        }

        return preg_match('/^[\w\-]{20,}+$/u', trim($value)) > 0;
    }
}