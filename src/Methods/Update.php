<?php

namespace Telegram\Bot\Methods;

use Psr\Http\Message\RequestInterface;
use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Events\UpdateWasReceived;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Update as UpdateObject;
use Telegram\Bot\Objects\WebhookInfo;
use Telegram\Bot\Traits\Http;

/**
 * Class Update.
 *
 * @mixin Http
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
     *   'allowed_updates' => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @param  array  $params [
     *
     * @var int            Optional. Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates. By default, updates starting with the earliest unconfirmed update are returned. An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id. The negative offset can be specified to retrieve updates starting from -offset update from the end of the updates queue. All previous updates will forgotten.
     * @var int             Optional. Limits the number of updates to be retrieved. Values between 1—100 are accepted. Defaults to 100.
     * @var int           Optional. Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling. Should be positive, short polling should be used for testing purposes only.
     * @var array Optional. List the types of updates you want your bot to receive. For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all updates regardless of type (default). If not specified, the previous setting will be used.
     *
     * ]
     *
     * @return UpdateObject[]
     *
     * @throws TelegramSDKException
     */
    public function getUpdates(array $params = [], bool $shouldDispatchEvents = true): array
    {
        $response = $this->get('getUpdates', $params);

        return collect($response->getResult())
            ->map(function ($data) use ($shouldDispatchEvents): UpdateObject {
                $update = new UpdateObject($data);

                if ($shouldDispatchEvents) {
                    $this->dispatchUpdateEvent($update);
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
     *   'max_connections' => '',
     *   'allowed_updates' => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @param  array  $params [
     *
     * @var string                Required. HTTPS url to send updates to. Use an empty string to remove webhook integration
     * @var InputFile     Optional. Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
     * @var int       Optional. Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot‘s server, and higher values to increase your bot’s throughput.
     * @var array     Optional. List the types of updates you want your bot to receive. For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all updates regardless of type (default). If not specified, the previous setting will be used.
     *
     * ]
     *
     * @throws TelegramSDKException
     */
    public function setWebhook(array $params): bool
    {
        $this->validateHookUrl($params['url']);

        if (isset($params['certificate'])) {
            $params['certificate'] = $this->formatCertificate($params['certificate']);

            return $this->uploadFile('setWebhook', $params, 'certificate')->getResult();
        }

        return $this->post('setWebhook', $params)->getResult();
    }

    /**
     * Remove webhook integration if you decide to switch back to getUpdates.
     *
     * @link https://core.telegram.org/bots/api#deletewebhook
     *
     * @throws TelegramSDKException
     */
    public function deleteWebhook(): bool
    {
        return $this->get('deleteWebhook')->getResult();
    }

    /**
     * Get current webhook status.
     *
     * @link https://core.telegram.org/bots/api#getwebhookinfo
     *
     * @throws TelegramSDKException
     */
    public function getWebhookInfo(): WebhookInfo
    {
        $response = $this->get('getWebhookInfo');

        return new WebhookInfo($response->getDecodedBody());
    }

    /**
     * Alias for getWebhookUpdate.
     *
     * @deprecated Call method getWebhookUpdate (note lack of letter s at end)
     *             To be removed in next major version.
     */
    public function getWebhookUpdates(bool $shouldDispatchEvents = true): UpdateObject
    {
        return $this->getWebhookUpdate($shouldDispatchEvents);
    }

    /**
     * Returns a webhook update sent by Telegram.
     * Works only if you set a webhook.
     *
     * @see setWebhook
     */
    public function getWebhookUpdate(bool $shouldDispatchEvents = true, ?RequestInterface $request = null): UpdateObject
    {
        $body = $this->getRequestBody($request);

        $update = new UpdateObject($body);

        if ($shouldDispatchEvents) {
            $this->dispatchUpdateEvent($update);
        }

        return $update;
    }

    /**
     * Alias for deleteWebhook.
     *
     *
     * @throws TelegramSDKException
     */
    public function removeWebhook(): bool
    {
        return $this->deleteWebhook();
    }

    /**
     * @throws TelegramSDKException
     */
    private function validateHookUrl(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new TelegramSDKException('Invalid URL Provided');
        }

        if (parse_url($url, PHP_URL_SCHEME) !== 'https') {
            throw new TelegramSDKException('Invalid URL, should be a HTTPS url.');
        }
    }

    private function formatCertificate($certificate): InputFile
    {
        if ($certificate instanceof InputFile) {
            return $certificate;
        }

        return InputFile::create($certificate, 'certificate.pem');
    }

    private function getRequestBody(?RequestInterface $request): mixed
    {
        $rawBody = $request instanceof RequestInterface ? (string) $request->getBody() : file_get_contents('php://input');

        return json_decode($rawBody, true);
    }

    /** Dispatch Update Event. */
    protected function dispatchUpdateEvent(UpdateObject $update): void
    {
        if (! $this->hasEventDispatcher()) {
            return;
        }

        $dispatcher = $this->eventDispatcher();

        $dispatcher->dispatch(new UpdateWasReceived($this, $update));
        $dispatcher->dispatch(new UpdateEvent($this, $update));

        $updateType = $update->objectType();
        if (is_string($updateType)) {
            $dispatcher->dispatch(new UpdateEvent($this, $update, $updateType));

            if (method_exists($update->getMessage(), 'objectType')) {
                $messageType = $update->getMessage()->objectType();

                if (null !== $messageType) {
                    $dispatcher->dispatch(new UpdateEvent($this, $update, sprintf('%s.%s', $updateType, $messageType)));
                }
            }
        }
    }
}
