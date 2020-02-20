<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\GameHighScore;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Traits\Http;

/**
 * Class Game.
 * @mixin Http
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
     * @param array $params [
     *
     * @var int|string $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var string     $game_short_name      Required. Short name of the game, serves as the unique identifier for the game. Set up your games via Botfather.
     * @var bool       $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int        $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string     $reply_markup         Optional. A JSON-serialized object for an inline keyboard. If empty, one ‘Play game_title’ button will be shown. If not empty, the first button must launch the game.
     *
     * ]
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
     * @param array $params [
     *
     * @var int    $user_id              Required. User identifier
     * @var int    $score                Required. New score, must be non-negative
     * @var bool   $force                Optional. Pass True, if the high score is allowed to decrease. This can be useful when fixing mistakes or banning cheaters
     * @var bool   $disable_edit_message Optional. Pass True, if the game message should not be automatically edited to include the current scoreboard
     * @var int    $chat_id              Optional. Required if inline_message_id is not specified. Unique identifier for the target chat
     * @var int    $message_id           Optional. Required if inline_message_id is not specified. Identifier of the sent message
     * @var string $inline_message_id    Optional. Required if chat_id and message_id are not specified. Identifier of the inline message
     *
     * ]
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
     * @param array $params [
     *
     * @var int        $user_id           Required. Target user id
     * @var int|string $chat_id           Optional. Required if inline_message_id is not specified. Unique identifier for the target chat
     * @var int        $message_id        Optional. Required if inline_message_id is not specified. Identifier of the sent message
     * @var string     $inline_message_id Optional. Required if chat_id and message_id are not specified. Identifier of the inline message
     *
     * ]
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
