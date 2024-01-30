<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#iddocumentdata
 *
 * @property string $documentNo Document number
 * @property string|null $expiryDate (Optional). Date of expiry, in DD.MM.YYYY format
 */
class IdDocumentData extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [
        ];
    }
}
