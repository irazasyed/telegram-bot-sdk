<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\BaseObject;
use Telegram\Bot\Objects\File;
use Telegram\Bot\Objects\Message as MessageObject;
use Telegram\Bot\Objects\Sticker;
use Telegram\Bot\Objects\StickerSet;
use Telegram\Bot\TelegramResponse;
use Telegram\Bot\Traits\Http;

/**
 * Methods for working with stickers and sticker sets.
 *
 * @mixin Http
 */
trait Stickers
{
    /**
     * Send a static .WEBP, animated .TGS, or video .WEBM sticker.
     *
     * <code>
     * $params = [
     *     'business_connection_id'     => '',                      // string           - (Optional). Unique identifier of the business connection
     *     'chat_id'                    => '',                      // int|string       - Required. Target chat identifier or username
     *     'message_thread_id'           => '',                      // int              - (Optional). Target message thread identifier
     *     'direct_messages_topic_id'    => '',                      // int              - (Optional). Target direct messages topic identifier
     *     'receiver_user_id'            => '',                      // int              - (Optional). Receiver of an ephemeral message
     *     'callback_query_id'           => '',                      // string           - (Optional). Callback query that triggered an ephemeral message
     *     'sticker'                     => InputFile::create($file), // InputFile|string - Required. Sticker file, file_id, or HTTP URL
     *     'emoji'                       => '',                      // string           - (Optional). Emoji for a newly uploaded sticker
     *     'disable_notification'        => '',                      // bool             - (Optional). Send silently
     *     'protect_content'             => '',                      // bool             - (Optional). Protect from forwarding and saving
     *     'allow_paid_broadcast'        => '',                      // bool             - (Optional). Allow paid high-throughput broadcasting
     *     'message_effect_id'           => '',                      // string           - (Optional). Message effect identifier
     *     'suggested_post_parameters'   => '',                      // array|string     - (Optional). Suggested post parameters
     *     'reply_parameters'            => '',                      // array|string     - (Optional). Reply parameters
     *     'reply_markup'                => '',                      // object|string    - (Optional). Reply markup
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @throws TelegramSDKException
     */
    public function sendSticker(array $params): MessageObject
    {
        $params = $this->encodeStickerJsonParams($params, ['suggested_post_parameters', 'reply_parameters']);
        $sticker = $params['sticker'] ?? null;
        $response = is_string($sticker) && $this->isUrl($sticker)
            ? $this->post('sendSticker', $params)
            : $this->uploadFile('sendSticker', $params, 'sticker');

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Get a sticker set.
     *
     * @link https://core.telegram.org/bots/api#getstickerset
     *
     * @throws TelegramSDKException
     */
    public function getStickerSet(array $params): StickerSet
    {
        return new StickerSet($this->post('getStickerSet', $params)->getDecodedBody());
    }

    /**
     * Get information about custom emoji stickers by their identifiers.
     *
     * <code>
     * $params = [
     *     'custom_emoji_ids' => ['5368324170671202286'], // string[] - Required. Up to 200 identifiers
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getcustomemojistickers
     *
     * @return Sticker[]
     *
     * @throws TelegramSDKException
     */
    public function getCustomEmojiStickers(array $params): array
    {
        $params = $this->encodeStickerJsonParams($params, ['custom_emoji_ids']);

        return collect($this->post('getCustomEmojiStickers', $params)->getResult())
            ->mapInto(Sticker::class)
            ->all();
    }

    /**
     * Upload a sticker file for later use in sticker set methods.
     *
     * <code>
     * $params = [
     *     'user_id'        => '',                       // int       - Required. Sticker file owner
     *     'sticker'        => InputFile::create($file), // InputFile - Required. .WEBP, .PNG, .TGS, or .WEBM file
     *     'sticker_format' => 'static',                 // string    - Required. static, animated, or video
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#uploadstickerfile
     *
     * @throws TelegramSDKException
     */
    public function uploadStickerFile(array $params): File
    {
        return new File($this->uploadFile('uploadStickerFile', $params, 'sticker')->getDecodedBody());
    }

    /**
     * Create a sticker set with 1-50 initial stickers.
     *
     * Each sticker can contain an InputFile directly; the SDK will turn it into
     * an attach:// reference and build the multipart request automatically.
     *
     * <code>
     * $params = [
     *     'user_id'          => '',
     *     'name'             => 'animals_by_example_bot',
     *     'title'            => 'Animals',
     *     'stickers'         => [
     *         [
     *             'sticker'    => InputFile::create($file),
     *             'format'     => 'static',
     *             'emoji_list' => ['🐼'],
     *             'keywords'   => ['panda'],
     *         ],
     *     ],
     *     'sticker_type'     => 'regular', // (Optional). regular, mask, or custom_emoji
     *     'needs_repainting' => false,     // (Optional). Custom emoji sets only
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#createnewstickerset
     *
     * @throws TelegramSDKException
     */
    public function createNewStickerSet(array $params): bool
    {
        return $this->postInputStickerRequest('createNewStickerSet', $params, 'stickers', true)->getResult();
    }

    /**
     * Add a sticker to a set created by the bot.
     *
     * <code>
     * $params = [
     *     'user_id' => '',
     *     'name'    => 'animals_by_example_bot',
     *     'sticker' => [
     *         'sticker'    => InputFile::create($file),
     *         'format'     => 'video',
     *         'emoji_list' => ['🐼'],
     *     ],
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#addstickertoset
     *
     * @throws TelegramSDKException
     */
    public function addStickerToSet(array $params): bool
    {
        return $this->postInputStickerRequest('addStickerToSet', $params, 'sticker')->getResult();
    }

    /**
     * Move a sticker to a zero-based position in its set.
     *
     * @link https://core.telegram.org/bots/api#setstickerpositioninset
     *
     * @throws TelegramSDKException
     */
    public function setStickerPositionInSet(array $params): bool
    {
        return $this->post('setStickerPositionInSet', $params)->getResult();
    }

    /**
     * Delete a sticker from a set created by the bot.
     *
     * @link https://core.telegram.org/bots/api#deletestickerfromset
     *
     * @throws TelegramSDKException
     */
    public function deleteStickerFromSet(array $params): bool
    {
        return $this->post('deleteStickerFromSet', $params)->getResult();
    }

    /**
     * Replace an existing sticker in a sticker set.
     *
     * @link https://core.telegram.org/bots/api#replacestickerinset
     *
     * @throws TelegramSDKException
     */
    public function replaceStickerInSet(array $params): bool
    {
        return $this->postInputStickerRequest('replaceStickerInSet', $params, 'sticker')->getResult();
    }

    /**
     * Change the emoji associated with a regular or custom emoji sticker.
     *
     * @link https://core.telegram.org/bots/api#setstickeremojilist
     *
     * @throws TelegramSDKException
     */
    public function setStickerEmojiList(array $params): bool
    {
        $params = $this->encodeStickerJsonParams($params, ['emoji_list']);

        return $this->post('setStickerEmojiList', $params)->getResult();
    }

    /**
     * Change search keywords assigned to a regular or custom emoji sticker.
     *
     * @link https://core.telegram.org/bots/api#setstickerkeywords
     *
     * @throws TelegramSDKException
     */
    public function setStickerKeywords(array $params): bool
    {
        $params = $this->encodeStickerJsonParams($params, ['keywords']);

        return $this->post('setStickerKeywords', $params)->getResult();
    }

    /**
     * Change or remove the mask position of a mask sticker.
     *
     * @link https://core.telegram.org/bots/api#setstickermaskposition
     *
     * @throws TelegramSDKException
     */
    public function setStickerMaskPosition(array $params): bool
    {
        $params = $this->encodeStickerJsonParams($params, ['mask_position']);

        return $this->post('setStickerMaskPosition', $params)->getResult();
    }

    /**
     * Change the title of a sticker set created by the bot.
     *
     * @link https://core.telegram.org/bots/api#setstickersettitle
     *
     * @throws TelegramSDKException
     */
    public function setStickerSetTitle(array $params): bool
    {
        return $this->post('setStickerSetTitle', $params)->getResult();
    }

    /**
     * Set or remove the thumbnail of a regular or mask sticker set.
     *
     * The required format parameter must be static, animated, or video. Omit
     * thumbnail to drop the custom thumbnail and use the first sticker.
     *
     * @link https://core.telegram.org/bots/api#setstickersetthumbnail
     *
     * @throws TelegramSDKException
     */
    public function setStickerSetThumbnail(array $params): bool
    {
        $thumbnail = $params['thumbnail'] ?? null;
        if ($thumbnail === null || $thumbnail === '' || (is_string($thumbnail) && ($this->isFileId($thumbnail) || $this->isUrl($thumbnail)))) {
            return $this->post('setStickerSetThumbnail', $params)->getResult();
        }

        return $this->uploadFile('setStickerSetThumbnail', $params, 'thumbnail')->getResult();
    }

    /**
     * Set the thumbnail of a custom emoji sticker set.
     *
     * @link https://core.telegram.org/bots/api#setcustomemojistickersetthumbnail
     *
     * @throws TelegramSDKException
     */
    public function setCustomEmojiStickerSetThumbnail(array $params): bool
    {
        return $this->post('setCustomEmojiStickerSetThumbnail', $params)->getResult();
    }

    /**
     * Delete a sticker set created by the bot.
     *
     * @link https://core.telegram.org/bots/api#deletestickerset
     *
     * @throws TelegramSDKException
     */
    public function deleteStickerSet(array $params): bool
    {
        return $this->post('deleteStickerSet', $params)->getResult();
    }

    /**
     * @deprecated Bot API 6.6 renamed this method and its thumb parameter. Use
     *             setStickerSetThumbnail() with thumbnail and format instead.
     *
     * @throws TelegramSDKException
     */
    public function setStickerSetThumb(array $params): bool
    {
        if (array_key_exists('thumb', $params) && ! array_key_exists('thumbnail', $params)) {
            $params['thumbnail'] = $params['thumb'];
        }

        unset($params['thumb']);

        return $this->setStickerSetThumbnail($params);
    }

    /**
     * JSON-encode Bot API parameters while preserving already serialized input.
     */
    private function encodeStickerJsonParams(array $params, array $fields): array
    {
        foreach ($fields as $field) {
            if (! array_key_exists($field, $params)) {
                continue;
            }

            if ($params[$field] === null) {
                continue;
            }

            if (is_string($params[$field])) {
                continue;
            }

            $params[$field] = json_encode($params[$field], JSON_THROW_ON_ERROR);
        }

        return $params;
    }

    /**
     * Serialize InputSticker data and lift nested InputFile instances into
     * multipart parts referenced through attach:// names.
     */
    private function postInputStickerRequest(
        string $endpoint,
        array $params,
        string $field,
        bool $multiple = false
    ): TelegramResponse {
        if (! array_key_exists($field, $params) || is_string($params[$field])) {
            return $this->post($endpoint, $params);
        }

        $inputStickers = $multiple ? $params[$field] : [$params[$field]];
        $preparedStickers = [];
        $attachments = [];

        foreach ($inputStickers as $inputSticker) {
            if ($inputSticker instanceof BaseObject) {
                $inputSticker = $inputSticker->getRawResponse();
            }

            if (is_array($inputSticker) && ($inputSticker['sticker'] ?? null) instanceof InputFile) {
                $attachmentName = $this->nextStickerAttachmentName($params, $attachments);
                $attachments[$attachmentName] = $inputSticker['sticker'];
                $inputSticker['sticker'] = 'attach://'.$attachmentName;
            }

            $preparedStickers[] = $inputSticker;
        }

        $params[$field] = json_encode(
            $multiple ? $preparedStickers : $preparedStickers[0],
            JSON_THROW_ON_ERROR
        );

        if ($attachments === []) {
            return $this->post($endpoint, $params);
        }

        $params = array_merge($params, $attachments);

        return $this->post(
            $endpoint,
            $this->prepareMultipartParams($params, (string) array_key_first($attachments)),
            true
        );
    }

    /**
     * Generate a multipart attachment name that cannot overwrite a user param.
     */
    private function nextStickerAttachmentName(array $params, array $attachments): string
    {
        $suffix = (string) count($attachments);
        $name = 'sticker_'.$suffix;

        while (array_key_exists($name, $params) || array_key_exists($name, $attachments)) {
            $suffix .= '_file';
            $name = 'sticker_'.$suffix;
        }

        return $name;
    }
}
