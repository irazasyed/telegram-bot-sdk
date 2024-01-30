<?php

namespace Telegram\Bot\Objects;

/**
 * Class VoiceChatEnded.
 *
 * @link https://core.telegram.org/bots/api#voicechatended
 *
 * @property int $duration Voice chat duration in seconds
 */
class VoiceChatEnded extends BaseObject
{
    /** {@inheritDoc} */
    public function relations(): array
    {
        return [];
    }
}
