<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * Class PassportElementError.
 * This object represents an error in the Telegram Passport element
 * which was submitted that should be resolved by the user.
 */
class PassportElementError extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
