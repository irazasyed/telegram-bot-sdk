<?php

namespace Telegram\Bot\Objects\WebApp;

use Telegram\Bot\Objects\BaseObject;

/**
 * Class Chat.
 *
 * @link https://core.telegram.org/bots/api#webappdata
 *
 * @property string $data The data. Be aware that a bad client can send arbitrary data in this field.
 * @property string $buttonText Text of the web_app keyboard button from which the Web App was opened. Be aware that a bad client can send arbitrary data in this field.
 */
class WebAppData extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
