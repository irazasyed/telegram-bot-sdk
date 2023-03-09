<?php

namespace Telegram\Bot\Objects;

/**
 * Class Poll.
 *
 * @link https://core.telegram.org/bots/api#poll
 *
 * @property string                 $id                     Unique poll identifier
 * @property string                 $question               Poll question, 1-255 characters.
 * @property PollOption[]           $options                List of poll options
 * @property int                    $totalVoterCount        Total number of users that voted in the poll
 * @property bool                   $isClosed               True, if the poll is closed.
 * @property bool                   $isAnonymous            True, if the poll is anonymous.
 * @property string                 $type                   Poll type, currently can be “regular” or “quiz”
 * @property bool                   $allowMultipleAnswers   True, if the poll allows multiple answers.
 * @property int|null               $correctOptionId        (Optional). 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.
 * @property string|null            $explanation            (Optional). Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters
 * @property MessageEntity[]|null   $explanationEntities    (Optional). Special entities like usernames, URLs, bot commands, etc. that appear in the explanation
 * @property int|null               $openPeriod             (Optional). Amount of time in seconds the poll will be active after creation
 * @property int|null               $closeDate              (Optional). Point in time (Unix timestamp) when the poll will be automatically closed
 */
class Poll extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{options: string[]}
     */
    public function relations(): array
    {
        return [
            'options' => [PollOption::class],
        ];
    }
}
