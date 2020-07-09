<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Payments\LabeledPrice;
use Telegram\Bot\Objects\Payments\ShippingOption;
use Telegram\Bot\Traits\Http;
use Illuminate\Support\Arr;

/**
 * Trait Payments.
 * @mixin Http
 */
trait Payments
{
    /**
     * Send invoices.
     *
     * <code>
     * $params = [
     *   'chat_id'                 => '',
     *   'title'                   => '',
     *   'description'             => '',
     *   'payload'                 => '',
     *   'provider_token'          => '',
     *   'start_parameter'         => '',
     *   'currency'                => '',
     *   'prices'                  => '',
     *   'photo_url'               => '',
     *   'photo_size'              => '',
     *   'photo_width'             => '',
     *   'photo_height'            => '',
     *   'need_name'               => '',
     *   'need_phone_number'       => '',
     *   'need_email'              => '',
     *   'need_shipping_address'   => '',
     *   'is_flexible'             => '',
     *   'disable_notification'    => '',
     *   'reply_to_message_id'     => '',
     *   'reply_markup'            => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendinvoice
     *
     * @param array        $params              [
     *
     * @var int            $chat_id                         Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var string         $title                           Required. Product name, 1-32 characters
     * @var string         $description                     Required. Product description, 1-255 characters
     * @var string         $payload                         Required. Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
     * @var string         $providerToken                   Required. Payments provider token, obtained via Botfather
     * @var string         $startParameter                  Required. Unique deep-linking parameter that can be used to generate this invoice when used as a start parameter
     * @var string         $currency                        Required. Three-letter ISO 4217 currency code
     * @var LabeledPrice[] $prices                          Required. Price breakdown, a list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
     * @var string         $provider_data                   Optional. JSON-encoded data about the invoice, which will be shared with the payment provider. A detailed description of required fields should be provided by the payment provider.
     * @var string         $photoUrl                        Optional. URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service. People like it better when they see what they are paying for.
     * @var int            $photoSize                       Optional. Photo size
     * @var int            $photoWidth                      Optional. Photo width
     * @var int            $photoHeight                     Optional. Photo height
     * @var bool           $needName                        Optional. Pass True, if you require the user's full name to complete the order
     * @var bool           $needPhoneNumber                 Optional. Pass True, if you require the user's phone number to complete the order
     * @var bool           $needEmail                       Optional. Pass True, if you require the user's email to complete the order
     * @var bool           $needShippingAddress             Optional. Pass True, if you require the user's shipping address to complete the order
     * @var bool           $send_phone_number_to_provider   Optional. Pass True, if user's phone number should be sent to provider
     * @var bool           $send_email_to_provider          Optional. Pass True, if user's email address should be sent to provider
     * @var bool           $isFlexible                      Optional. Pass True, if the final price depends on the shipping method
     * @var bool           $disableNotification             Optional. Sends the message silently. Users will receive a notification with no sound.
     * @var int            $reply_to_message_id             Optional. If the message is a reply, ID of the original message
     * @var string         $reply_markup                    Optional. A JSON-serialized object for an inline keyboard. If empty, one 'Pay total price' button will be shown. If not empty, the first button must be a Pay button.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return Message
     */
    public function sendInvoice(array $params): Message
    {
        $params['prices'] = json_encode(Arr::wrap($params['prices']));
        $response = $this->post('sendInvoice', $params);

        return new Message($response->getDecodedBody());
    }

    /**
     * Reply to shipping queries.
     *
     * <code>
     * $params = [
     *   'shipping_query_id'  => '',
     *   'ok'                 => '',
     *   'shipping_options'   => '',
     *   'error_message'      => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#answershippingquery
     *
     * @param array          $params          [
     *
     * @var string           $shippingQueryId Required. Unique identifier for the query to be answered
     * @var bool             $ok              Required. Specify True if delivery to the specified address is possible and False if there are any problems (for example, if delivery to the specified address is not possible)
     * @var ShippingOption[] $shippingOptions (Optional|Required). Required if ok is True. A JSON-serialized array of available shipping options.
     * @var string           $errorMessage    (Optional|Required). Required if ok is False. Error message in human readable form that explains why it is impossible to complete the order (e.g. "Sorry, delivery to your desired address is unavailable'). Telegram will display this message to the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function answerShippingQuery(array $params): bool
    {
        $response = $this->post('answerShippingQuery', $params);

        return $response->getResult();
    }

    /**
     * Reply to pre-checkout queries.
     *
     * <code>
     * $params = [
     *   'pre_checkout_query_id'  => '',
     *   'ok'                     => '',
     *   'error_message'          => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#answerprecheckoutquery
     *
     * @param array          $params          [
     *
     * @var string           $preCheckoutQueryId Required. Unique identifier for the query to be answered
     * @var bool             $ok              Required. Specify True if everything is alright (goods are available, etc.) and the bot is ready to proceed with the order. Use False if there are any problems.
     * @var string           $errorMessage    (Optional|Required). Required if ok is False. Error message in human readable form that explains the reason for failure to proceed with the checkout (e.g. "Sorry, somebody just bought the last of our amazing black T-shirts while you were busy filling out your payment details. Please choose a different color or garment!"). Telegram will display this message to the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function answerPreCheckoutQuery(array $params): bool
    {
        $response = $this->post('answerPreCheckoutQuery', $params);

        return $response->getResult();
    }
}
