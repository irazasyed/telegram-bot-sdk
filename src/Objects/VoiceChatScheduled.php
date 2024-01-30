<?php

namespace Telegram\Bot\Objects;

/**
 * Class VoiceChatScheduled.
 *
 * @link https://core.telegram.org/bots/api#voicechatscheduled
 *
 * @property int $start_date Point in time (Unix timestamp) when the voice chat is supposed to be started by a chat administrator
 */
class VoiceChatScheduled extends BaseObject
{
    /** {@inheritDoc} */
    public function relations(): array
    {
        return [];
    }
}
