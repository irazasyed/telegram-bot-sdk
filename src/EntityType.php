<?php

namespace Telegram\Bot;

/**
 * Class EntityType.
 */
final class EntityType
{
    /** Sets MessageEntity Type as mention. */
    public const MENTION = 'mention';

    /** Sets MessageEntity Type as hashtag . */
    public const HASHTAG = 'hashtag';

    /** Sets MessageEntity Type as cashtag. */
    public const CASHTAG = 'cashtag';

    /** Sets MessageEntity Type as Bot Command. */
    public const BOT_COMMAND = 'bot_command';

    /** Sets MessageEntity Type as url. */
    public const URL = 'url';

    /** Sets MessageEntity Type as email. */
    public const EMAIL = 'email';

    /** Sets MessageEntity Type as phone number. */
    public const PHONE_NUMBER = 'phone_number';

    /** Sets MessageEntity Type as bold. */
    public const BOLD = 'bold';

    /** Sets MessageEntity Type as italic. */
    public const ITALIC = 'italic';

    /** Sets MessageEntity Type as underline. */
    public const UNDERLINE = 'underline';

    /** Sets MessageEntity Type as strike through. */
    public const STRIKETHROUGH = 'strikethrough';

    /** Sets MessageEntity Type as spoiler . */
    public const SPOILER = 'spoiler';

    /** Sets MessageEntity Type as code. */
    public const CODE = 'code';

    /** Sets MessageEntity Type as pre. */
    public const PRE = 'code';

    /** Sets MessageEntity Type as text link. */
    public const TEXT_LINK = 'text_link';

    /** Sets MessageEntity Type as text mention. */
    public const TEXT_MENTION = 'text_mention';
}
