<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\TelegramResponse;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Objects\WebhookInfo;
use Telegram\Bot\Objects\Update as UpdateObject;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class Update
 */
trait Update
{
    /**
     * Use this method to receive incoming updates using long polling.
     *
     * <code>
     * $params = [
     *   'offset'  => '',
     *   'limit'   => '',
     *   'timeout' => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @param array  $params
     * @param bool   $shouldEmitEvents
     *
     * @var int|null $params ['offset']
     * @var int|null $params ['limit']
     * @var int|null $params ['timeout']
     *
     * @throws TelegramSDKException
     *
     * @return UpdateObject[]
     */
    public function getUpdates(array $params = [], $shouldEmitEvents = true): array
    {
        $response = $this->get('getUpdates', $params);

        return collect($response->getResult())
            ->map(function ($data) use ($shouldEmitEvents) {

                $update = new UpdateObject($data);

                if ($shouldEmitEvents) {
                    $this->emitEvent(new UpdateWasReceived($update, $this));
                }

                return $update;
            })
            ->all();
    }

    /**
     * Set a Webhook to receive incoming updates via an outgoing webhook.
     *
     * <code>
     * $params = [
     *   'url'         => '',
     *   'certificate' => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @param array $params
     *
     * @var string  $params ['url']         HTTPS url to send updates to.
     * @var string  $params ['certificate'] Upload your public key certificate so that the root certificate in
     *                                      use can be checked.
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    public function setWebhook(array $params): TelegramResponse
    {
        if (filter_var($params['url'], FILTER_VALIDATE_URL) === false) {
            throw new TelegramSDKException('Invalid URL Provided');
        }

        if (parse_url($params['url'], PHP_URL_SCHEME) !== 'https') {
            throw new TelegramSDKException('Invalid URL, should be a HTTPS url.');
        }

        return $this->uploadFile('setWebhook', $params, 'certificate');
    }

    /**
     * Remove webhook integration if you decide to switch back to getUpdates.
     *
     * @link https://core.telegram.org/bots/api#deletewebhook
     *
     * @return TelegramResponse
     */
    public function deleteWebhook(): TelegramResponse
    {
        return $this->get('deleteWebhook');
    }

    /**
     * Get current webhook status.
     *
     * @link https://core.telegram.org/bots/api#getwebhookinfo
     *
     * @return WebhookInfo
     */
    public function getWebhookInfo(): WebhookInfo
    {
        $response = $this->get('getWebhookInfo');

        return new WebhookInfo($response->getDecodedBody());
    }

    /**
     * Alias for getWebhookUpdate
     *
     * @deprecated Call method getWebhookUpdate (note lack of letter s at end)
     *             To be removed in next major version.
     *
     * @param bool $shouldEmitEvent
     *
     * @return UpdateObject
     */
    public function getWebhookUpdates($shouldEmitEvent = true): UpdateObject
    {
        return $this->getWebhookUpdate($shouldEmitEvent);
    }

    /**
     * Returns a webhook update sent by Telegram.
     * Works only if you set a webhook.
     *
     * @see setWebhook
     *
     * @param bool $shouldEmitEvent
     *
     * @return UpdateObject
     */
    public function getWebhookUpdate($shouldEmitEvent = true): UpdateObject
    {
        $body = json_decode(file_get_contents('php://input'), true);

        $update = new UpdateObject($body);

        if ($shouldEmitEvent) {
            $this->emitEvent(new UpdateWasReceived($update, $this));
        }

        return $update;
    }

    /**
     * Alias for deleteWebhook.
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    public function removeWebhook(): TelegramResponse
    {
        return $this->deleteWebhook();
    }
}