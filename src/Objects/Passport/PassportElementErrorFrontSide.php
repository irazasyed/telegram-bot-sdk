<?php

namespace Telegram\Bot\Objects\Passport;

/**
 * Class PassportElementErrorFrontSide.
 *
 * Represents an issue with the front side of a document. The error is considered resolved when the file with the front side of the document changes.
 *
 * @property string $source                          Error source, must be front_side
 * @property string $type                            The section of the user's Telegram Passport which has the issue, one of “passport”, “driver_license”, “identity_card”, “internal_passport”
 * @property string $fileHash                        Base64-encoded hash of the file with the front side of the document
 * @property string $message                         Error message
 */
class PassportElementErrorFrontSide extends PassportElementError
{
}
