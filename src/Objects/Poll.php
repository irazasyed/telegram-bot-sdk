<?php

namespace Telegram\Bot\Objects;

/**
 * Class Poll.
 *
 *
 * @property string       $id                     Unique poll identifier
 * @property string       $question               Poll question, 1-255 characters.
 * @property PollOption[] $options                List of poll options
 * @property int          $totalVoterCount        Total number of users that voted in the poll
 * @property bool         $isClosed               True, if the poll is closed.
 * @property bool         $isAnonymous            True, if the poll is anonymous.
 * @property string       $type                   Poll type, currently can be “regular” or “quiz”
 * @property bool         $allowMultipleAnswers   True, if the poll allows multiple answers.
 * @property int          $correctOptionId        Optional. 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.
 */
class Poll extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'options' => PollOption::class,
        ];
    }
}
