<?php

namespace Telegram\Bot\Objects;

/**
 * Class CallbackQuery.
 *
 * @method User     getFrom()           Sender
 * @method Message  getMessage()        (Optional). Message with the callback button that originated the query.
 * @method string   getData()           (Optional). Data associated with the callback button.
 * @method string   getId()             (Optional). Callback id.
 */
class CallbackQuery extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'from' => User::class,
            'message' => Message::class,
        ];
    }
}
