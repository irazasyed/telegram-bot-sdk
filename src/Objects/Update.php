<?php

namespace Telegram\Bot\Objects;

/**
 * Class Update.
 *
 *
 * @method int                  getUpdateId()               The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially.
 * @method Message              getMessage()                (Optional). New incoming message of any kind - text, photo, sticker, etc.
 * @method EditedMessage        getEditedMessage()          (Optional). New version of a message that is known to the bot and was edited.
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
            'edited_message'       => EditedMessage::class,
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
    
    /**
     * Determine if the update is of given type
     *
     * @param string         $type
     *
     * @return bool
     */
    public function isType($type)
    {
        if ($this->has(strtolower($type))) {
            return true;
        }
    
        return $this->detectType() === $type;
    }
    
    /**
     * Detect type based on properties.
     *
     * @return string|null
     */
    public function detectType()
    {
        $types = [
            'message',
            'edited_message',
            'inline_query',
            'chosen_inline_result',
            'callback_query',
        ];

        return $this->keys()
            ->intersect($types)
            ->pop();
    }
    
    /**
     * Get message object (if exists)
     *
     * @return null|Chat
     */
    public function getChat()
    {
        switch ($this->detectType())
        {
            case 'message':
                return $this->getMessage()->getChat();
            case 'callback_query':
                return $this->getCallbackQuery()->getMessage()->getChat();
            default:
                // nothing to return
                return null;
        }
    }
}
