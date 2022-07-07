<?php

namespace Telegram\Bot\Objects\InputMedia;

/**
 * Class InputMediaPhoto.
 *
 * Represents a photo to be sent.
 *
 * @link https://core.telegram.org/bots/api#inputmediaphoto
 *
 * @property string      $type             Type of the result, must be photo.
 * @property string      $media            File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
 * @property string|null $caption          (Optional). Caption of the photo to be sent, 0-200 characters
 * @property string|null $parseMode        (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 */
class InputMediaPhoto extends InputMedia
{
}
