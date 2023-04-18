<?php

namespace Telegram\Bot;

use ReflectionClass;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class Actions.
 *
 * Chat Actions let you broadcast a type of action depending on what the user is about to receive.
 * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing
 * status).
 */
final class Actions
{
    /** Sets chat status as Typing.
     * @var string */
    public const TYPING = 'typing';

    /** Sets chat status as Sending Photo.
     * @var string */
    public const UPLOAD_PHOTO = 'upload_photo';

    /** Sets chat status as Recording Video.
     * @var string */
    public const RECORD_VIDEO = 'record_video';

    /** Sets chat status as Sending Video.
     * @var string */
    public const UPLOAD_VIDEO = 'upload_video';

    /**
     * @deprecated Please use RECORD_VOICE (the correct one)
     * Sets chat status as Recording Audio.
     *
     * @var string
     */
    public const RECORD_AUDIO = 'record_voice';

    /** Sets chat status as Recording Voice.
     * @var string */
    public const RECORD_VOICE = 'record_voice';

    /**
     * @deprecated Please use UPLOAD_VOICE (the correct one)
     * Sets chat status as Sending Audio.
     *
     * @var string
     */
    public const UPLOAD_AUDIO = 'upload_voice';

    /** Sets chat status as Sending Voice.
     * @var string */
    public const UPLOAD_VOICE = 'upload_voice';

    /** Sets chat status as Sending Document.
     * @var string */
    public const UPLOAD_DOCUMENT = 'upload_document';

    /** Sets chat status as Choosing Sticker.
     * @var string */
    public const CHOOSE_STICKER = 'choose_sticker';

    /** Sets chat status as Choosing Geo.
     * @var string */
    public const FIND_LOCATION = 'find_location';

    /** Sets chat status as Recording Video Note.
     * @var string */
    public const RECORD_VIDEO_NOTE = 'record_video_note';

    /** Sets chat status as Sending Video Note.
     * @var string */
    public const UPLOAD_VIDEO_NOTE = 'upload_video_note';

    public static function all(): array
    {
        return (new ReflectionClass(self::class))->getConstants();
    }

    public static function isActionValid(string $action): bool
    {
        $actions = self::all();
        if (in_array($action, $actions, true)) {
            return true;
        }

        throw new TelegramSDKException('Invalid Action! Accepted value: '.implode(', ', $actions));
    }
}
