<?php

namespace Telegram\Bot\Objects;

/**
 * Class Update.
 *
 *
 * @property int                $updateId               The update's unique identifier. Update identifiers start from a
 *                                                      certain positive number and increase sequentially.
 * @property Message            $message                (Optional). New incoming message of any kind - text, photo,
 *                                                      sticker, etc.
 * @property EditedMessage      $editedMessage          (Optional). New version of a message that is known to the bot
 *                                                      and was edited.
 * @property InlineQuery        $inlineQuery            (Optional). New incoming inline query.
 * @property ChosenInlineResult $chosenInlineResult     (Optional). A result of an inline query that was chosen by the
 *                                                      user and sent to their chat partner.
 * @property CallbackQuery      $callbackQuery          (Optional). Incoming callback query.
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
     * @param string $type
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
     * Returns message.
     *
     * @return null|EditedMessage|Message
     */
    public function getMessage()
    {
        if ($this->has('message')) {
            return $this->message;
        } elseif ($this->has('edited_message')) {
            return $this->editedMessage;
        }

        return null;
    }
}
