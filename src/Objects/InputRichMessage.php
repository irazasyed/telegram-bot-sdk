<?php

declare(strict_types=1);

namespace Telegram\Bot\Objects;

/**
 * A rich message to be sent using Markdown or HTML formatting.
 *
 * Exactly one of html or markdown must be specified.
 *
 * @link https://core.telegram.org/bots/api#inputrichmessage
 *
 * @property string|null $html (Optional). Rich message content using HTML formatting.
 * @property string|null $markdown (Optional). Rich message content using Markdown formatting.
 * @property bool|null $isRtl (Optional). True, if the message must be shown right-to-left.
 * @property bool|null $skipEntityDetection (Optional). True, to skip automatic entity detection.
 */
class InputRichMessage extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
