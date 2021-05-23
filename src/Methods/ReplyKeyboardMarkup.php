<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Keyboard\Keyboard;

trait ReplyKeyboardMarkup
{
    public function replyKeyboardMarkup(array $params)
    {
        return Keyboard::make($params);
    }
}
