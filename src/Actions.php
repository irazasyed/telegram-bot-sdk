<?php

namespace Telegram\Bot;

/**
 * Class Actions
 *
 * @package Telegram\Bot
 */
class Actions
{
    /** @var string Set chat status as Typing */
    const TYPING = 'typing';

    /** @var string Set chat status as Sending Photo */
    const UPLOAD_PHOTO = 'upload_photo';

    /** @var string Set chat status as Sending Video */
    const UPLOAD_VIDEO = 'upload_video';

    /** @var string Set chat status as Sending Audio */
    const UPLOAD_AUDIO = 'upload_audio';

    /** @var string Set chat status as Sending Document */
    const UPLOAD_DOCUMENT = 'upload_document';

    /** @var string Set chat status as Choosing Geo */
    const FIND_LOCATION = 'find_location';

    /** @var string Set chat status as Recording Video */
    const RECORD_VIDEO = 'record_video';
}