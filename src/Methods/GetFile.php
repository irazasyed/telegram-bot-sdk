<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\File;

/**
 * Class GetFile
 *
 * Returns basic info about a file and prepare it for downloading.
 *
 * <code>
 * $params = [
 *   'file_id' => '',
 * ];
 * </code>
 *
 * The file can then be downloaded via the link
 * https://api.telegram.org/file/bot<token>/<file_path>,
 * where <file_path> is taken from the response.
 *
 * @link https://core.telegram.org/bots/api#getfile
 *
 * @method GetFile fileId($fileId) string
 *
 * @method File getResult($dumpAndDie = false)
 */
class GetFile extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return File::class;
    }
}