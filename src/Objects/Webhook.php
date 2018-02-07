<?php

namespace Telegram\Bot\Objects;

/**
 * Class Webhook
 *
 * @method string       getUrl()                    Webhook URL, may be empty if webhook is not set up
 * @method bool         getHasCustomCertificate()   True, if a custom certificate was provided for webhook certificate checks
 * @method int          getPendingUpdateCount()     Number of updates awaiting delivery
 * @method int          getLastErrorDate()          Optional. Unix time for the most recent error that happened when
 *                                                      trying to deliver an update via webhook
 * @method string       getLastErrorMessage()       Optional. Error message in human-readable format for the most
 *                                                      recent error that happened when trying to deliver an update via webhook
 * @method int          getMaxConnections()         Optional. Maximum allowed number of simultaneous HTTPS connections
 *                                                      to the webhook for update delivery
 * @method array|string getAllowedUpdates()         Optional. A list of update types the bot is subscribed to.
 *                                                      Defaults to all update types
 *
 * @package Telegram\Bot\Objects
 * @link https://core.telegram.org/bots/api#webhookinfo
 */
class Webhook extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
