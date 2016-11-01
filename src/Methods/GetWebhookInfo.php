<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\WebhookInfo;

/**
 * Class GetWebhookInfo
 *
 * Use this method to get current webhook status. Requires no parameters.
 * On success, returns a WebhookInfo object. If the bot is using getUpdates,
 * will return an object with the url field empty.
 *
 * @link https://core.telegram.org/bots/api#getwebhookinfo
 *
 * @method WebhookInfo getResult($dumpAndDie = false)
 */
class GetWebhookInfo extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected $noParams = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return WebhookInfo::class;
    }
}