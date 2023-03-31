<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChosenInlineResult.
 *
 * @link https://core.telegram.org/bots/api#choseninlineresult
 *
 * @property string        $resultId           The unique identifier for the result that was chosen.
 * @property User          $from               The user that chose the result.
 * @property Location|null $location           (Optional). Sender location, only for bots that require user location.
 * @property string|null   $inlineMessageId    (Optional). Identifier of the sent inline message. Available only if there is an inline keyboard attached to the message. Will be also received in callback queries and can be used to edit the message.
 * @property string        $query              The query that was used to obtain the result.
 *
 * @link https://core.telegram.org/bots/api#choseninlineresult
 */
class ChosenInlineResult extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{from: string, location: string}
     */
    public function relations(): array
    {
        return [
            'from' => User::class,
            'location' => Location::class,
        ];
    }

    public function objectType(): ?string
    {
        return $this->findType(['location', 'inline_message_id']);
    }
}
