<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\User;

/**
 * Class GetMe
 *
 * A simple method for testing your bot's auth token.
 * Returns basic information about the bot in form of a User object.
 *
 * @link https://core.telegram.org/bots/api#getme
 *
 * @method User getResult($dumpAndDie = false)
 * @method User go($dumpAndDie = false) Alias for getResult().
 */
class GetMe extends Method
{
    /** {@inheritdoc} */
    protected $noParams = true;

    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return User::class;
    }
}