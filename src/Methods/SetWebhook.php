<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\TelegramResponse;

/**
 * Class SetWebhook
 *
 * Set a Webhook to receive incoming updates via an outgoing webhook.
 *
 * <code>
 * $params = [
 *   'url'             => '',
 *   'certificate'     => '',
 *   'max_connections' => '',
 *   'allowed_updates' => [],
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#setwebhook
 *
 * @method SetWebhook url($url) string                      HTTPS url to send updates to.
 * @method SetWebhook certificate(InputFile $certificate)   InputFile Upload your public key certificate so that the root
 *                                                          certificate in use can be checked.
 * @method SetWebhook maxConnections($maxConnections) int   Maximum allowed number of simultaneous HTTPS connections to the webhook for update
 *                                                          delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot‘s server,
 *                                                          and higher values to increase your bot’s throughput.
 * @method SetWebhook allowedUpdates($allowedUpdates) array List the types of updates you want your bot to receive. For example, specify [“message”,
 *                                                          “edited_channel_post”, “callback_query”] to only receive updates of these types.
 *                                                          Specify an empty list to receive all updates regardless of type (default).
 *                                                          If not specified, the previous setting will be used.
 *
 * @method TelegramResponse getResult($dumpAndDie = false)
 */
class SetWebhook extends Method
{
    /** {@inheritdoc} */
    protected $fileUploadField = 'certificate';

    /** {@inheritdoc} */
    protected function beforeCallHook()
    {
        if (filter_var($this->payload['url'], FILTER_VALIDATE_URL) === false) {
            throw new TelegramSDKException('Invalid URL Provided');
        }

        if (parse_url($this->payload['url'], PHP_URL_SCHEME) !== 'https') {
            throw new TelegramSDKException('Invalid URL, should be a HTTPS url.');
        }

        if (!isset($this->payload['certificate']) || !is_readable($this->payload['certificate'])) {
            $this->payload['certificate'] = null;
            //TODO @irazasyed - We need to chat about the following line. :-)
            $this->fileUploadField = null;
        }
    }

    /** {@inheritdoc} */
    protected function returns()
    {
        return $this->factory->response();
    }
}
