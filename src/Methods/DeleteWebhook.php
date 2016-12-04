<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class DeleteWebhook
 *
 * Remove webhook integration.
 *
 * @link https://core.telegram.org/bots/api#deletewebhook
 *
 * @method bool getResult($dumpAndDie = false)
 */
class DeleteWebhook extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected $noParams = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return $this->factory->response();
    }
}
