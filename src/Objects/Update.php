<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Collection;
use Telegram\Bot\Objects\Payments\PreCheckoutQuery;
use Telegram\Bot\Objects\Payments\ShippingQuery;

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
 * @property Message            $channelPost            (Optional).Optional. New incoming channel post of any kind — text,
 *                                                      photo, sticker, etc.
 * @property EditedMessage      $editedChannelPost      (Optional). New version of a channel post that is known to the
 *                                                      bot and was edited sticker, etc.
 * @property InlineQuery        $inlineQuery            (Optional). New incoming inline query.
 * @property ChosenInlineResult $chosenInlineResult     (Optional). A result of an inline query that was chosen by the
 *                                                      user and sent to their chat partner.
 * @property CallbackQuery      $callbackQuery          (Optional). Incoming callback query.
 * @property ShippingQuery      $shippingQuery          (Optional). New incoming shipping query. Only for invoices with
 *                                                      flexible price
 * @property PreCheckoutQuery   $preCheckoutQuery       (Optional). New incoming pre-checkout query. Contains full
 *                                                      information about checkout
 * @property Poll               $poll                   (Optional). Optional. New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
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
            'channel_post'         => Message::class,
            'edited_channel_post'  => EditedMessage::class,
            'inline_query'         => InlineQuery::class,
            'chosen_inline_result' => ChosenInlineResult::class,
            'callback_query'       => CallbackQuery::class,
            'shipping_query'       => ShippingQuery::class,
            'pre_checkout_query'   => PreCheckoutQuery::class,
            'poll'                 => Poll::class,
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
     * Determine if the update is of given type.
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
            'channel_post',
            'edited_channel_post',
            'inline_query',
            'chosen_inline_result',
            'callback_query',
            'shipping_query',
            'pre_checkout_query',
            'poll',
        ];

        return $this->keys()
            ->intersect($types)
            ->pop();
    }

    /**
     * Get the message contained in the Update.
     *
     * @return Message|EditedMessage|Collection
     */
    public function getMessage(): Collection
    {
        switch ($this->detectType()) {
            case 'message':
                return $this->message;
            case 'edited_message':
                return $this->editedMessage;
            case 'channel_post':
                return $this->channelPost;
            case 'edited_channel_post':
                return $this->editedChannelPost;
            case 'inline_query':
                return $this->inlineQuery;
            case 'chosen_inline_result':
                return $this->chosenInlineResult;
            case 'callback_query':
                $callbackQuery = $this->callbackQuery;
                if ($callbackQuery->has('message')) {
                    return $callbackQuery->message;
                }
                break;
            case 'shipping_query':
                return $this->shippingQuery;
            case 'pre_checkout_query':
                return $this->preCheckoutQuery;
            case 'poll':
                return $this->poll;
        }

        return collect();
    }

    /**
     * Get chat object (if exists).
     *
     * @return Chat|Collection
     */
    public function getChat(): Collection
    {
        $message = $this->getMessage();

        return $message->has('chat') ? $message->get('chat') : collect();
    }

    /**
     * Is there a command entity in this update object.
     *
     * @return bool
     */
    public function hasCommand()
    {
        return (bool) $this->getMessage()->get('entities', collect())->contains('type', 'bot_command');
    }
}
