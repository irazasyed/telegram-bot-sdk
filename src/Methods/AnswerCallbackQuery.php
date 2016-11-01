<?php
namespace Telegram\Bot\Methods;

/**
 * Class AnswerCallbackQuery
 *
 * Use this method to send answers to callback queries sent from inline keyboards.
 * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
 * On success, True is returned.
 *
 * <code>
 * $params = [
 *   'callback_query_id'  => '',
 *   'text'               => '',
 *   'show_alert'         => '',
 *   'url'                => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#answercallbackquery
 *
 * @method AnswerCallbackQuery callbackQueryId($callbackQueryId) string
 * @method AnswerCallbackQuery text($text) string
 * @method AnswerCallbackQuery showAlert($showAlert) bool
 * @method AnswerCallbackQuery url($url) string
 *
 * @method bool getResult($dumpAndDie = false)
 */
class AnswerCallbackQuery extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return true;
    }
}