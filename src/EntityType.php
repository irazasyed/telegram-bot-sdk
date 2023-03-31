<?php

namespace Telegram\Bot;

/**
 * Class EntityType.
 */
final class EntityType
{
    /** Sets MessageEntity Type as mention.
     * @var string */
    public const MENTION = 'mention';

    /** Sets MessageEntity Type as hashtag .
     * @var string */
    public const HASHTAG = 'hashtag';

    /** Sets MessageEntity Type as cashtag.
     * @var string */
    public const CASHTAG = 'cashtag';

    /** Sets MessageEntity Type as Bot Command.
     * @var string */
    public const BOT_COMMAND = 'bot_command';

    /** Sets MessageEntity Type as url.
     * @var string */
    public const URL = 'url';

    /** Sets MessageEntity Type as email.
     * @var string */
    public const EMAIL = 'email';

    /** Sets MessageEntity Type as phone number.
     * @var string */
    public const PHONE_NUMBER = 'phone_number';

    /** Sets MessageEntity Type as bold.
     * @var string */
    public const BOLD = 'bold';

    /** Sets MessageEntity Type as italic.
     * @var string */
    public const ITALIC = 'italic';

    /** Sets MessageEntity Type as underline.
     * @var string */
    public const UNDERLINE = 'underline';

    /** Sets MessageEntity Type as strike through.
     * @var string */
    public const STRIKETHROUGH = 'strikethrough';

    /** Sets MessageEntity Type as spoiler .
     * @var string */
    public const SPOILER = 'spoiler';

    /** Sets MessageEntity Type as code.
     * @var string */
    public const CODE = 'code';

    /** Sets MessageEntity Type as pre.
     * @var string */
    public const PRE = 'code';

    /** Sets MessageEntity Type as text link.
     * @var string */
    public const TEXT_LINK = 'text_link';

    /** Sets MessageEntity Type as text mention.
     * @var string */
    public const TEXT_MENTION = 'text_mention';
}
