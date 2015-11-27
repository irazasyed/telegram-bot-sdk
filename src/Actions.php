<?php

namespace Telegram\Bot;

/**
 * Class Actions.
 *
 * Chat Actions let you broadcast a type of action depending on what the user is about to receive.
 * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing
 * status).
 */
class Actions
{
    /**
     * Sets chat status as Typing.
     *
     * @var string
     */
    const TYPING = 'typing';

    /**
     * Sets chat status as Sending Photo.
     *
     * @var string
     */
    const UPLOAD_PHOTO = 'upload_photo';

    /**
     * Sets chat status as Sending Video.
     *
     * @var string
     */
    const UPLOAD_VIDEO = 'upload_video';

    /**
     * Sets chat status as Sending Audio.
     *
     * @var string
     */
    const UPLOAD_AUDIO = 'upload_audio';

    /**
     * Sets chat status as Sending Document.
     *
     * @var string
     */
    const UPLOAD_DOCUMENT = 'upload_document';

    /**
     * Sets chat status as Choosing Geo.
     *
     * @var string
     */
    const FIND_LOCATION = 'find_location';

    /**
     * Sets chat status as Recording Video.
     *
     * @var string
     */
    const RECORD_VIDEO = 'record_video';
}
