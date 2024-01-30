<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#passportscope
 *
 * @property PassportScopeElement[] $data List of requested elements, each type may be used only once in the entire array of PassportScopeElement objects
 * @property int $v Scope version, must be 1
 */
class PassportScope extends BaseObject
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
