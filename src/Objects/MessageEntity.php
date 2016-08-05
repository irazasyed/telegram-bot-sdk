<?php

namespace Telegram\Bot\Objects;

/**
 * Class Location.
 *
 *
 * @method string   getType()   Type of the entity. Can be mention (@username), hashtag, bot_command, url, email, bold (bold text), italic (italic text), code (monowidth string), pre (monowidth block), text_link (for clickable text URLs), text_mention (for users without usernames).
 * @method int      getOffset() Offset in UTF-16 code units to the start of the entity
 * @method int      getLength() Length of the entity in UTF-16 code units
 * @method string   getUrl()    (Optional). For "text_link" only, url that will be opened after user taps on the text.
 * @method User     getUser()   (Optional). For “text_mention” only, the mentioned user.
 */
class MessageEntity extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
