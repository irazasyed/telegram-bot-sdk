<?php

namespace Telegram\Bot\Objects\InputMedia;

use Telegram\Bot\FileUpload\InputFile;

/**
 * Class InputMediaAnimation.
 * Represents an animation file (GIF or H.264/MPEG-4 AVC video without sound) to be sent.
 *
 * @property string           $type         Type of the result, must be animation.
 * @property string           $media        File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
 * @property InputFile|string $thumb        (Optional). Thumbnail of the file sent. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail‘s width and height should not exceed 90. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can’t be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>
 * @property string           $caption      (Optional). Caption of the animation to be sent, 0-200 characters
 * @property string           $parseMode    (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @property int              $width        (Optional). Animation width
 * @property int              $height       (Optional). Animation height
 * @property int              $duration     (Optional). Animation duration
 */
class InputMediaAnimation extends InputMedia
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'thumb' => InputFile::class,
        ];
    }
}
