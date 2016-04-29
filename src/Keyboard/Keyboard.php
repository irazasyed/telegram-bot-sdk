<?php
namespace Telegram\Bot\Keyboard;

/**
 * Class Keyboard
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
    /**
     * Make an Inline Keyboard
     *
     * @var bool
     */
    protected $inline = false;

    /**
     * Make this keyboard inline, So it appears right next to the message it belongs to.
     *
     * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
     *
     * @return $this
     */
    public function inline()
    {
        $this->inline = true;

        return $this;
    }

    /**
     * Determine if it's an inline keyboard.
     *
     * @return bool
     */
    public function isInlineKeyboard()
    {
        return $this->inline;
    }

    /**
     * Create a new row in keyboard to add buttons.
     *
     * @return $this
     */
    public function row()
    {
        $property = 'keyboard';
        if ($this->isInlineKeyboard()) {
            $property = 'inline_keyboard';
        }

        $this->items[$property][] = func_get_args();

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
     * @param string|array $params
     *
     * @var string         $params ['text']
     * @var bool           $params ['request_contact']
     * @var bool           $params ['request_location']
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
     *   'text'                 => '',
     *   'url'                  => '',
     *   'callback_data'        => '',
     *   'switch_inline_query'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#inlinekeyboardbutton
     *
     * @param string|array $params
     *
     * @var string         $params ['text']
     * @var string         $params ['url']
     * @var string         $params ['callback_data']
     * @var string         $params ['switch_inline_query']
     *
     * @return string
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
     *   'hide_keyboard' => true,
     *   'selective'     => false,
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#replykeyboardhide
     *
     * @param array $params
     *
     * @var bool    $params ['hide_keyboard']
     * @var bool    $params ['selective']
     *
     * @return string
     */
    public static function hide(array $params = [])
    {
        return new static(array_merge(['hide_keyboard' => true, 'selective' => false], $params));
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
     * @param array $params
     *
     * @var bool    $params ['force_reply']
     * @var bool    $params ['selective']
     *
     * @return string
     */
    public static function forceReply(array $params = [])
    {
        return new static(array_merge(['force_reply' => true, 'selective' => false], $params));
    }
}
