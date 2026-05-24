<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputTextMessageContent.
 *
 * Represents the content of a text message to be sent as the result of an inline query.
 *
 * <code>
 * [
 *   'message_text'              => '',  //  string  - Required. Text of the message to be sent, 1-4096 characters.
 *   'parse_mode'                => '',  //  string  - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
 *   'entities'                  => '',  //  array   - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 *   'disable_web_page_preview'  => '',  //  bool    - (Optional). Disables link previews for links in the sent message
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inputtextmessagecontent
 *
 * @method $this setMessageText(string) Text of the message to be sent, 1-4096 characters.
 * @method $this setParseMode(string) (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
 * @method $this setDisableWebPagePreview(bool) (Optional). Disables link previews for links in the sent message
 */
class InputTextMessageContent extends InlineBaseObject
{
}
