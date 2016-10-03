<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\GameHighScore;

/**
 * Class GetGameHighScores
 *
 * Use this method to get data for high score tables.
 * Will return the score of the specified user and several of his neighbors in a game.
 * On success, returns an Array of GameHighScore objects.
 *
 * <code>
 * $params = [
 *   'user_id'           => '',
 *   'chat_id'           => '',
 *   'message_id'        => '',
 *   'inline_message_id' => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#getgamehighscores
 *
 * @method GetGameHighScores userId($userId) int
 * @method GetGameHighScores chatId($chatId) int|string
 * @method GetGameHighScores messageId($messageId) int
 * @method GetGameHighScores inlineMessageId($inlineMessageId) string
 *
 * @method GameHighScore[] getResult($dumpAndDie = false)
 * @method GameHighScore[] go($dumpAndDie = false) Alias for getResult().
 */
class GetGameHighScores extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return collect($this->factory->response()->getResult())
            ->map(function ($data) {
                return new GameHighScore($data);
            })
            ->all();
    }
}