<?php

namespace Telegram\Bot\Keyboard;

use Telegram\Bot\Objects\LoginUrl;

/**
 * Class Keyboard.
 *
 * <code>
 * // For Standard Keyboard
 * $params = [
 *   'keyboard'          => '',
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
 * @method $this setResizeKeyboard($boolean)     Optional. Requests clients to resize the keyboard vertically for optimal fit.
 * @method $this setOneTimeKeyboard($boolean)    Optional. Requests clients to hide the keyboard as soon as it's been used.
 * @method $this setSelective($boolean)          Optional. Use this parameter if you want to show the keyboard to specific users only.
 */
class Keyboard extends Base
{
    /** @var bool Make an Inline Keyboard */
    protected $inline = false;

    /**
     * Make this keyboard inline, So it appears right next to the message it belongs to.
     *
     * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
     *
     * @return Keyboard
     */
    public function inline(): self
    {
        $this->inline = true;

        return $this;
    }

    /**
     * Determine if it's an inline keyboard.
     *
     * @return bool
     */
    public function isInlineKeyboard(): bool
    {
        return $this->inline;
    }

    /**
     * Create a new row in keyboard to add buttons.
     *
     * @param array $buttons
     *
     * @return Keyboard
     */
    public function row(...$buttons): self
    {
        $property = $this->isInlineKeyboard() ? 'inline_keyboard' : 'keyboard';
        $this->items[$property][] = $buttons;

        return $this;
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
     *
     * @param string|array $params           [
     *
     * @var string         $text             Required. Text of the button. If none of the optional fields are used, it will be sent to the bot as a message when the button is pressed
     * @var bool           $request_contact  Optional. If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only
     * @var bool           $request_location Optional. If True, the user's current location will be sent when the button is pressed. Available in private chats only
     *
     * ]
     *
     * @return mixed
     */
    public static function button($params = [])
    {
        if (is_string($params)) {
            return $params;
        }

        return Button::make($params);
    }

    /**
     * Represents one button of an inline keyboard.
     *
     * You must use exactly one of the optional fields.
     * You can also utilise the fluent API to build the params payload.
     *
     * <code>
     * $params = [
     *   'text'                                 => '',
     *   'url'                                  => '',
     *   'login_url'                            => '',
     *   'callback_data'                        => '',
     *   'switch_inline_query'                  => '',
     *   'switch_inline_query_current_chat'     => '',
     *   'callback_game'                        => '',
     *   'pay'                                  => '',
     *
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#inlinekeyboardbutton
     *
     * @param array  $params                           [
     *
     * @var string   $text                             Required. Label text on the button
     * @var string   $url                              Optional. HTTP url to be opened when button is pressed
     * @var LoginUrl $url                              Optional. An HTTP URL used to automatically authorize the user. Can be used as a replacement for the Telegram Login Widget.
     * @var string   $callback_data                    Optional. Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
     * @var string   $switch_inline_query              Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot‘s username and the specified inline query in the input field. Can be empty, in which case just the bot’s username will be inserted.
     * @var string   $switch_inline_query_current_chat Optional. If set, pressing the button will insert the bot‘s username and the specified inline query in the current chat's input field. Can be empty, in which case only the bot’s username will be inserted.
     * @var string   $callback_game                    Optional. Description of the game that will be launched when the user presses the button. NOTE: This type of button must always be the first button in the first row.
     * @var string   $pay                              Optional. Specify True, to send a Pay button. NOTE: This type of button must always be the first button in the first row.
     *
     * ]
     *
     * @return mixed
     */
    public static function inlineButton($params = [])
    {
        return self::button($params);
    }

    /**
     * Hide the current custom keyboard and display the default letter-keyboard.
     *
     * <code>
     * $params = [
     *   'remove_keyboard' => true,
     *   'selective'     => false,
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#replykeyboardremove
     *
     * @param array $params          [
     *
     * @var bool    $remove_keyboard Required. Requests clients to remove the custom keyboard (user will not be able to summon this keyboard; if you want to hide the keyboard from sight but keep it accessible, use one_time_keyboard in ReplyKeyboardMarkup)
     * @var bool    $selective       Optional. Use this parameter if you want to remove the keyboard for specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     *
     * ]
     *
     * @return Keyboard
     */
    public static function remove(array $params = []): self
    {
        return new static(array_merge(['remove_keyboard' => true, 'selective' => false], $params));
    }

    /**
     * Display a reply interface to the user (act as if the user has selected the bot‘s message and tapped ’Reply').
     *
     * <code>
     * $params = [
     *   'force_reply' => true,
     *   'selective'   => false,
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#forcereply
     *
     * @param array $params      [
     *
     * @var bool    $force_reply Required. Shows reply interface to the user, as if they manually selected the bot‘s message and tapped ’Reply'
     * @var bool    $selective   Optional. Use this parameter if you want to force reply from specific users only. Targets: 1) users that are @mentioned in the text of the Message object; 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     *
     * ]
     *
     * @return Keyboard
     */
    public static function forceReply(array $params = []): self
    {
        return new static(array_merge(['force_reply' => true, 'selective' => false], $params));
    }
}
