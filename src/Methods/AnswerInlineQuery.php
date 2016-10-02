<?php
namespace Telegram\Bot\Methods;

/**
 * Class AnswerInlineQuery
 *
 * Use this method to send answers to an inline query.
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
 * @link https://core.telegram.org/bots/api#answerinlinequery
 *
 * @method AnswerInlineQuery inlineQueryId($inlineQueryId) string
 * @method AnswerInlineQuery results(array $results = []) array
 * @method AnswerInlineQuery cacheTime($cacheTime = null) int|null
 * @method AnswerInlineQuery isPersonal($isPersonal = null) bool|null
 * @method AnswerInlineQuery nextOffset($nextOffset = null) string|null
 * @method AnswerInlineQuery switchPmText($switchPmText = null) string|null
 * @method AnswerInlineQuery switchPmParameter($switchPmParameter = null) string|null
 *
 * @method bool getResult($dumpAndDie = false)
 * @method bool go($dumpAndDie = false) Alias for getResult().
 */
class AnswerInlineQuery extends Method
{
    /** {@inheritdoc} */
    protected function beforeCallHook()
    {
        if (is_array($this->payload['results'])) {
            $this->payload['results'] = json_encode($this->payload['results']);
        }
    }

    /** {@inheritdoc} */
    protected function returns()
    {
        return true;
    }
}