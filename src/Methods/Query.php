<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class Query
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
     *   'callback_query_id'  => '',
     *   'text'               => '',
     *   'show_alert'         => '',
     *   'url'                => '',
     *   'cache_time'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#answerCallbackQuery
     *
     * @param array $params
     *
     * @var string  $params ['callback_query_id']
     * @var string  $params ['text']
     * @var bool    $params ['show_alert']
     * @var string  $params ['url']
     * @var int     $params ['cache_time']
     *
     * @throws TelegramSDKException
     *
     * @return bool
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
     *   'inline_query_id'      => '',
     *   'results'              => [],
     *   'cache_time'           => 0,
     *   'is_personal'          => false,
     *   'next_offset'          => '',
     *   'switch_pm_text'       => '',
     *   'switch_pm_parameter'  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#answerCallbackQuery
     *
     * @param array $params
     *
     * @var string  $params ['inline_query_id']
     * @var array   $params ['results']
     * @var int     $params ['cache_time']
     * @var bool    $params ['is_personal']
     * @var string  $params ['next_offset']
     * @var string  $params ['switch_pm_text']
     * @var string  $params ['switch_pm_parameter']
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function answerInlineQuery(array $params): bool
    {
        $this->post('answerInlineQuery', $params);

        return true;
    }
}