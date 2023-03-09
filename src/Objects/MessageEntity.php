<?php

namespace Telegram\Bot\Objects;

/**
 * Class MessageEntity.
 *
 * @link https://core.telegram.org/bots/api#messageentity
 *
 * @property string      $type      Type of the entity. Can be “mention” (@username), “hashtag” (#hashtag), “cashtag” ($USD), “bot_command” (/start@jobs_bot), “url” (https://telegram.org), “email” (do-not-reply@telegram.org), “phone_number” (+1-212-555-0123), “bold” (bold text), “italic” (italic text), “underline” (underlined text), “strikethrough” (strikethrough text), “code” (monowidth string), “pre” (monowidth block), “text_link” (for clickable text URLs), “text_mention” (for users without usernames)
 * @property int         $offset    Offset in UTF-16 code units to the start of the entity
 * @property int         $length    Length of the entity in UTF-16 code units
 * @property string|null $url       (Optional). For "text_link" only, url that will be opened after user taps on the text.
 * @property User|null   $user      (Optional). For “text_mention” only, the mentioned user.
 * @property string|null $language  (Optional). For “pre” only, the programming language of the entity text.
 */
class MessageEntity extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{user: string}
     */
    public function relations(): array
    {
        return [
            'user' => User::class,
        ];
    }
}
