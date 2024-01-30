<?php

namespace Telegram\Bot\Objects;

/**
 * Class WebhookInfo.
 *
 * Contains information about the current status of a webhook.
 *
 * @link https://core.telegram.org/bots/api#webhookinfo
 *
 * @property string $url Webhook URL, may be empty if webhook is not set up
 * @property bool $hasCustomCertificate True, if a custom certificate was provided for webhook certificate checks
 * @property int $pendingUpdateCount Number of updates awaiting delivery
 * @property int|null $lastErrorDate (Optional). Unix time for the most recent error that happened when trying to deliver an update via webhook
 * @property string|null $lastErrorMessage (Optional). Error message in human-readable format for the most recent error that happened when trying to deliver an update via webhook
 * @property int|null $maxConnections (Optional). Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery
 * @property array|null $allowedUpdates (Optional). A list of update types the bot is subscribed to. Defaults to all update types
 */
class WebhookInfo extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
