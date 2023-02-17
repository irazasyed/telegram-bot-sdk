<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Traits\Http;

/**
 * Class Query.
 *
 * @mixin Http
 */
trait Query
{
    /**
     * Send answers to callback queries sent from inline keyboards.
     *
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
     *
     * <code>
     * $params = [
     *       'callback_query_id'  => '',  // string - Required. Unique identifier for the query to be answered
     *       'text'               => '',  // string - (Optional). Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters
     *       'show_alert'         => '',  // bool   - (Optional). If true, an alert will be shown by the client instead of a notification at the top of the chat screen. Defaults to false.
     *       'url'                => '',  // string - (Optional). URL that will be opened by the user's client. If you have created a Game and accepted the conditions via "@Botfather", specify the URL that opens your game – note that this will only work if the query comes from a callback_game button. Otherwise, you may use links like telegram.me/your_bot?start=XXXX that open your bot with a parameter.
     *       'cache_time'         => '',  // int    - (Optional). The maximum amount of time in seconds that the result of the callback query may be cached client-side. Telegram apps will support caching starting in version 3.14. Defaults to 0.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#answercallbackquery
     *
     * @throws TelegramSDKException
     */
    public function answerCallbackQuery(array $params): bool
    {
        $this->post('answerCallbackQuery', $params);

        return true;
    }

    /**
     * Send answers to an inline query.
     *
     * No more than 50 results per query are allowed.
     *
     * <code>
     * $params = [
     *       'inline_query_id'      => '',  // string - Required. Unique identifier for the answered query
     *       'results'              => '',  // array  - Required. A JSON-serialized array of results for the inline query
     *       'cache_time'           => '',  // int    - (Optional). The maximum amount of time in seconds that the result of the inline query may be cached on the server. Defaults to 300.
     *       'is_personal'          => '',  // bool   - (Optional). Pass True, if results may be cached on the server side only for the user that sent the query. By default, results may be returned to any user who sends the same query
     *       'next_offset'          => '',  // string - (Optional). Pass the offset that a client should send in the next query with the same text to receive more results. Pass an empty string if there are no more results or if you don‘t support pagination. Offset length can’t exceed 64 bytes.
     *       'switch_pm_text'       => '',  // string - (Optional). If passed, clients will display a button with specified text that switches the user to a private chat with the bot and sends the bot a start message with the parameter switch_pm_parameter
     *       'switch_pm_parameter'  => '',  // string - (Optional). Deep-linking parameter for the /start message sent to the bot when user presses the switch button. 1-64 characters, only A-Z, a-z, 0-9, _ and - are allowed.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#answerinlinequery
     *
     * @throws TelegramSDKException
     */
    public function answerInlineQuery(array $params): bool
    {
        $this->post('answerInlineQuery', $params);

        return true;
    }
}
