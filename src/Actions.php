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
    /** Sets chat status as Typing. */
    const TYPING = 'typing';

    /** Sets chat status as Sending Photo. */
    const UPLOAD_PHOTO = 'upload_photo';

    /** Sets chat status as Recording Video. */
    const RECORD_VIDEO = 'record_video';

    /** Sets chat status as Sending Video. */
    const UPLOAD_VIDEO = 'upload_video';

    /** Sets chat status as Recording Audio. */
    const RECORD_AUDIO = 'record_audio';

    /** Sets chat status as Sending Audio. */
    const UPLOAD_AUDIO = 'upload_audio';

    /** Sets chat status as Sending Document. */
    const UPLOAD_DOCUMENT = 'upload_document';

    /** Sets chat status as Choosing Geo. */
    const FIND_LOCATION = 'find_location';

    /** Sets chat status as Recording Video Note. */
    const RECORD_VIDEO_NOTE = 'record_video_note';

    /** Sets chat status as Sending Video Note. */
    const UPLOAD_VIDEO_NOTE = 'upload_video_note';
}
