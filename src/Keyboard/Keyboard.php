<?php

namespace Telegram\Bot\Keyboard;

/**
 * Class Keyboard.
 *
 * <code>
 * // For Standard Keyboard
 * $params = [
 *   'keyboard'          => '',
 *   'is_persistent'     => '',
 *   'resize_keyboard'   => '',
 *   'one_time_keyboard' => '',
 *   'selective'         => '',
 * ];
 * </code>
 *
 * OR
 *
 * <code>
 * // For Inline Keyboard
 * $params = [
 *   'inline_keyboard' => '',
 * ];
 * </code>
 *
 * @method $this setIsPersistent($boolean)       Optional. Requests clients to always show the keyboard when the regular keyboard is hidden.
 * @method $this setResizeKeyboard($boolean)     Optional. Requests clients to resize the keyboard vertically for optimal fit.
 * @method $this setOneTimeKeyboard($boolean)    Optional. Requests clients to hide the keyboard as soon as it's been used.
 * @method $this setSelective($boolean)          Optional. Use this parameter if you want to show the keyboard to specific users only.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @extends Base<TKey, TValue>
 */
final class Keyboard extends Base
{
    /** @var bool Make an Inline Keyboard */
    private bool $inline = false;

    /**
     * Represents one button of an inline keyboard.
     *
     * You must use exactly one of the optional fields.
     * You can also utilise the fluent API to build the params payload.
     *
     * <code>
     * $params = [
     *     'text'                                 => '',
     *     'url'                                  => '',
     *     'login_url'                            => '',
     *     'callback_data'                        => '',
     *     'switch_inline_query'                  => '',
     *     'switch_inline_query_current_chat'     => '',
     *     'callback_game'                        => '',
     *     'pay'                                  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#inlinekeyboardbutton
     */
    public static function inlineButton(string|array $params = []): string|array|Button
    {
        return self::button($params);
    }

    /**
     * Represents one button of the Reply keyboard.
     *
     * For simple text buttons String can be used instead of an array.
     * You can also utilise the fluent API to build the params payload.
     *
     * <code>
     * $params = 'string'
     *
     * OR
     *
     * $params = [
     *   'text'                 => '',
     *   'request_contact'      => '',
     *   'request_location'     => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#keyboardbutton
     */
    public static function button(string|array $params = []): string|array|Button
    {
        if (is_string($params)) {
            return $params;
        }

        return Button::make($params);
    }

    /**
     * Represents the `ReplyKeyboardRemove` class in the Telegram Bot API, which is used to request clients to remove
     * the custom keyboard and display the default letter-keyboard.
     *
     * <code>
     * $params = [
     *   'remove_keyboard' => true,
     *   'selective'     => false,
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#replykeyboardremove
     */
    public static function remove(array $params = []): self
    {
        return new self(array_merge(['remove_keyboard' => true, 'selective' => false], $params));
    }

    /**
     * Display a reply interface to the user (act as if the user has selected the bots message and tapped "Reply").
     *
     * <code>
     * $params = [
     *   'force_reply' => true,
     *   'selective'   => false,
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#forcereply
     */
    public static function forceReply(array $params = []): self
    {
        return new self(array_merge(['force_reply' => true, 'selective' => false], $params));
    }

    /**
     * Make this keyboard inline, So it appears right next to the message it belongs to.
     *
     * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
     */
    public function inline(): self
    {
        $this->inline = true;

        return $this;
    }

    /**
     * Determine if it's an inline keyboard.
     */
    public function isInlineKeyboard(): bool
    {
        return $this->inline;
    }

    /**
     * Create a new row in keyboard to add buttons.
     */
    public function row(array $buttons = []): self
    {
        $property = $this->inline ? 'inline_keyboard' : 'keyboard';
        $this->items[$property][] = $buttons;

        return $this;
    }
}
