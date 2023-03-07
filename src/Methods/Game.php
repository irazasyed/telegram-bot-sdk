<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\GameHighScore;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Traits\Http;

/**
 * Class Game.
 *
 * @mixin Http
 */
trait Game
{
    /**
     * Send a game.
     *
     * <code>
     * $params = [
     *       'chat_id'                      => '',  // int|string - Required. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'game_short_name'              => '',  // string     - Required. Short name of the game, serves as the unique identifier for the game. Set up your games via Botfather.
     *       'disable_notification'         => '',  // bool       - (Optional). Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     *       'protect_content'              => '',  // bool       - (Optional). Protects the contents of the sent message from forwarding and saving
     *       'reply_to_message_id'          => '',  // int        - (Optional). If the message is a reply, ID of the original message
     *       'allow_sending_without_reply   => '',  // bool       - (Optional). Pass True, if the message should be sent even if the specified replied-to message is not found
     *       'reply_markup'                 => '',  // string     - (Optional). A JSON-serialized object for an inline keyboard. If empty, one ‘Play game_title’ button will be shown. If not empty, the first button must launch the game.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendgame
     *
     * @throws TelegramSDKException
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
     *       'user_id'               => '',  // int    - Required. User identifier
     *       'score'                 => '',  // int    - Required. New score, must be non-negative
     *       'force'                 => '',  // bool   - (Optional). Pass True, if the high score is allowed to decrease. This can be useful when fixing mistakes or banning cheaters
     *       'disable_edit_message'  => '',  // bool   - (Optional). Pass True, if the game message should not be automatically edited to include the current scoreboard
     *       'chat_id'               => '',  // int    - (Optional). Required if inline_message_id is not specified. Unique identifier for the target chat
     *       'message_id'            => '',  // int    - (Optional). Required if inline_message_id is not specified. Identifier of the sent message
     *       'inline_message_id'     => '',  // string - (Optional). Required if chat_id and message_id are not specified. Identifier of the inline message
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setgamescore
     *
     * @throws TelegramSDKException
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
     *       'user_id'            => '',  // int        - Required. Target user id
     *       'chat_id'            => '',  // int|string - (Optional). Required if inline_message_id is not specified. Unique identifier for the target chat
     *       'message_id'         => '',  // int        - (Optional). Required if inline_message_id is not specified. Identifier of the sent message
     *       'inline_message_id'  => '',  // string     - (Optional). Required if chat_id and message_id are not specified. Identifier of the inline message
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getgamehighscores
     *
     * @return GameHighScore[]
     *
     * @throws TelegramSDKException
     */
    public function getGameHighScores(array $params): array
    {
        return collect($this->get('getGameHighScores', $params)->getResult())
            ->mapInto(GameHighScore::class)
            ->all();
    }
}
