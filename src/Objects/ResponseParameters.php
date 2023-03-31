<?php

namespace Telegram\Bot\Objects;

/**
 * Class ResponseParameters.
 *
 * Contains information about why a request was unsuccessful.
 *
 * @link https://core.telegram.org/bots/api#responseparameters
 *
 * @property int|null $migrateToChatId   (Optional). The group has been migrated to a supergroup with the specified identifier. This number may be greater than 32 bits and some programming languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64 bit integer or double-precision float type are safe for storing this identifier.
 * @property int|null $retryAfter        (Optional). In case of exceeding flood control, the number of seconds left to wait before the request can be repeated
 */
class ResponseParameters extends BaseObject
{
    public function relations(): array
    {
        return [];
    }
}
