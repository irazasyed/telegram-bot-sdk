<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;

/**
 * Class SetWebhook
 *
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
 * @method SetWebhook url($url) string HTTPS url to send updates to.
 * @method SetWebhook certificate(InputFile $certificate) InputFile Upload your public key certificate so that the root
 *         certificate in use can be checked.
 *
 * @method bool getResult($dumpAndDie = false)
 * @method bool go($dumpAndDie = false) Alias for getResult().
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
    }

    /** {@inheritdoc} */
    protected function returns()
    {
        return $this->factory->response();
    }
}