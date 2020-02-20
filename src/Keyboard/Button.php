<?php

namespace Telegram\Bot\Keyboard;

/**
 * Class Button.
 *
 * @method $this setRequestContact($boolean)    Optional. If True, the user's phone number will be sent as a contact when the button is pressed. Available in private chats only.
 * @method $this setRequestLocation($boolean)   Optional. If True, the user's current location will be sent when the button is pressed. Available in private chats only.
 * @method $this setUrl($string)                (Inline Button Only) Optional. HTTP url to be opened when button is pressed.
 * @method $this setCallbackData($string)       (Inline Button Only) Optional. Data to be sent in a callback query to the bot when button is pressed.
 * @method $this setSwitchInlineQuery($string)  (Inline Button Only) Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot‘s username and the specified inline query in the input field. Can be empty, in which case just the bot’s username will be inserted.
 * @method $this setSwitchInlineQueryCurrentChat($string)  (Inline Button Only) Optional. If set, pressing the button will insert the bot‘s username and the specified inline query in the current chat's input field. Can be empty, in which case only the bot’s username will be inserted.
 * @method $this setCallbackGame($string)  (Inline Button Only) Optional. Description of the game that will be launched when the user presses the button.
 */
class Button extends Base
{
    /**
     * Button Label Text.
     *
     * @param string $text
     *
     * @return Button
     */
    public function setText($text): self
    {
        $this->items['text'] = $text;

        return $this;
    }
}
