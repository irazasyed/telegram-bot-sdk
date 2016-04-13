<?php

namespace Telegram\Bot\Objects;

/**
 * Class Update.
 *
 *
 * @method int                  getUpdateId()               The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially.
 * @method Message              getMessage()                (Optional). New incoming message of any kind - text, photo, sticker, etc.
 * @method InlineQuery          getInlineQuery()            (Optional). New incoming inline query.
 * @method ChosenInlineResult   getChosenInlineResult()     (Optional). A result of an inline query that was chosen by the user and sent to their chat partner.
 * @method CallbackQuery        getCallbackQuery()          (Optional). Incoming callback query.
 *
 * @link https://core.telegram.org/bots/api#update
 */
class Update extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'message'              => Message::class,
            'inline_query'         => InlineQuery::class,
            'chosen_inline_result' => ChosenInlineResult::class,
            'callback_query'       => CallbackQuery::class,
        ];
    }

    /**
     * Get recent message.
     *
     * @return Update
     */
    public function recentMessage()
    {
        return new static($this->last());
    }
}
