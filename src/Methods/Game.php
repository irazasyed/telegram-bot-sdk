<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\{
    GameHighScore, Message
};
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class Game
 */
trait Game
{
    /**
     * Send a game.
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'game_short_name'          => '',
     *   'disable_notification'     => '',
     *   'reply_to_message_id'      => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendgame
     *
     * @param array $params
     *
     * @var int     $params ['chat_id']
     * @var string  $params ['game_short_name']
     * @var bool    $params ['disable_notification']
     * @var int     $params ['reply_to_message_id']
     * @var string  $params ['reply_markup']
     *
     * @throws TelegramSDKException
     *
     * @return Message
     */
    public function sendGame(array $params): Message
    {
        $response = $this->post('sendGame', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Set the score of the specified user in a game.
     *
     * <code>
     * $params = [
     *   'user_id'              => '',
     *   'score'                => '',
     *   'force'                => '',
     *   'disable_edit_message' => '',
     *   'chat_id'              => '',
     *   'message_id'           => '',
     *   'inline_message_id'    => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setgamescore
     *
     * @param array $params
     *
     * @var int     $params ['user_id']
     * @var int     $params ['score']
     * @var bool    $params ['force']
     * @var bool    $params ['disable_edit_message']
     * @var int     $params ['chat_id']
     * @var int     $params ['message_id']
     * @var string  $params ['inline_message_id']
     *
     * @throws TelegramSDKException
     *
     * @return Message
     */
    public function setGameScore(array $params): Message
    {
        $response = $this->post('setGameScore', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Set the score of the specified user in a game.
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
     * @param array $params
     *
     * @var int     $params ['user_id']
     * @var int     $params ['chat_id']
     * @var int     $params ['message_id']
     * @var string  $params ['inline_message_id']
     *
     * @throws TelegramSDKException
     *
     * @return GameHighScore[]
     */
    public function getGameHighScores(array $params): array
    {
        $response = $this->get('getGameHighScores', $params);

        return collect($response->getResult())
            ->map(function ($data) {
                return new GameHighScore($data);
            })
            ->all();
    }
}