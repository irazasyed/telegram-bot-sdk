<?php

namespace Telegram\Bot\Objects\Passport;

/**
 * Class PassportElementErrorUnspecified.
 *
 * Represents an issue in an unspecified place. The error is considered resolved when new data is added.
 *
 * @property string $source Error source, must be unspecified
 * @property string $type Type of element of the user's Telegram Passport which has the issue
 * @property string $elementHash Base64-encoded element hash
 * @property string $message Error message
 */
class PassportElementErrorUnspecified extends PassportElementError {}
