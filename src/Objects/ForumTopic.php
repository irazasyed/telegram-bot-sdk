<?php

namespace Telegram\Bot\Objects;

/**
 * Class ForumTopic.
 *
 * @link https://core.telegram.org/bots/api#forumtopic
 *
 * @property int $messageThreadId Unique identifier of the forum topic
 * @property string $name Name of the topic
 * @property int $iconColor Color of the topic icon in RGB format
 * @property string $iconCustomEmojiId (Optional). Unique identifier of the custom emoji shown as the topic icon
 */
class ForumTopic extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
