<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\File;
use Telegram\Bot\Objects\MaskPosition;
use Telegram\Bot\Objects\Message as MessageObject;
use Telegram\Bot\Objects\StickerSet;
use Telegram\Bot\Traits\Http;

/**
 * Class Message.
 * @mixin Http
 */
trait Stickers
{
    /**
     * Use this method to send static .WEBP or animated .TGS stickers.
     *
     * <code>
     * $params = [
     *   'chat_id'              => '',
     *   'sticker'              => InputFile::create($resourceOrFile, $filename),
     *   'disable_notification' => '',
     *   'reply_to_message_id'  => '',
     *   'reply_markup'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @param array          $params               [
     *
     * @var int|string       $chat_id              Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile|string $sticker              Required. Sticker to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a .webp file from the Internet, or upload a new one using multipart/form-data.
     * @var bool             $disable_notification Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int              $reply_to_message_id  Optional. If the message is a reply, ID of the original message
     * @var string           $reply_markup         Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return MessageObject
     */
    public function sendSticker(array $params): MessageObject
    {
        $response = $this->uploadFile('sendSticker', $params, 'sticker');

        return new MessageObject($response->getDecodedBody());
    }

    /**
     * Get a sticker set. On success, a StickerSet object is returned.
     *
     * <code>
     * $params = [
     *   'name'              => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getstickerset
     *
     * @param array $params [
     *
     * @var string  $name   Required. Name of the sticker set
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return StickerSet
     */
    public function getStickerSet(array $params): StickerSet
    {
        $response = $this->post('getStickerSet', $params);

        return new StickerSet($response->getDecodedBody());
    }

    /**
     * Upload a .png file with a sticker for later use in createNewStickerSet and addStickerToSet
     * methods (can be used multiple times).
     *
     * <code>
     * $params = [
     *   'user_id'              => '',
     *   'png_sticker'          => InputFile::create($resourceOrFile, $filename),
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#uploadstickerfile
     *
     * @param array   $params      [
     *
     * @var int       $user_id     Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var InputFile $png_sticker Required. Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return File
     */
    public function uploadStickerFile(array $params): File
    {
        $response = $this->uploadFile('uploadStickerFile', $params, 'png_sticker');

        return new File($response->getDecodedBody());
    }

    /**
     * Create new sticker set owned by a user.
     *
     * <code>
     * $params = [
     *   'user_id'           => '',
     *   'name'              => '',
     *   'title'             => '',
     *   'png_sticker'       => '',
     *   'tgs_sticker'       => '',
     *   'emojis'            => '',
     *   'contains_masks'    => '',
     *   'mask_position'     => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#createnewstickerset
     *
     * @param array          $params         [
     *
     * @var int              $user_id        Required. User identifier of created sticker set owner
     * @var string           $name           Required. Short name of sticker set, to be used in t.me/addstickers/ URLs (e.g., animals). Can contain only english letters, digits and underscores. Must begin with a letter, can't contain consecutive underscores and must end in “_by_<bot username>”. <bot_username> is case insensitive. 1-64 characters.
     * @var string           $title          Required. Sticker set title, 1-64 characters
     * @var InputFile|string $png_sticker    (Optional). Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data.
     * @var InputFile        $tgs_sticker    (Optional). TGS animation with the sticker, uploaded using multipart/form-data. See https://core.telegram.org/animated_stickers#technical-requirements for technical requirements
     * @var string           $emojis         Required. One or more emoji corresponding to the sticker
     * @var bool             $contains_masks (Optional). Pass True, if a set of mask stickers should be created
     * @var MaskPosition     $mask_position  (Optional). A JSON-serialized object for position where the mask should be placed on faces
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function createNewStickerSet(array $params): bool
    {
        $response = $this->uploadFile('createNewStickerSet', $params, 'png_sticker');

        return $response->getResult();
    }

    /**
     * Add a new sticker to a set created by the bot.
     *
     * <code>
     * $params = [
     *   'user_id'           => '',
     *   'name'              => '',
     *   'png_sticker'       => '',
     *   'tgs_sticker'       => '',
     *   'emojis'            => '',
     *   'mask_position'     => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#addstickertoset
     *
     * @param array          $params        [
     *
     * @var int              $user_id       Required. User identifier of sticker set owner
     * @var string           $name          Required. Sticker set name
     * @var InputFile|string $png_sticker   Required. Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data.
     * @var InputFile        $tgs_sticker   (Optional). TGS animation with the sticker, uploaded using multipart/form-data. See https://core.telegram.org/animated_stickers#technical-requirements for technical requirements
     * @var string           $emojis        Required. One or more emoji corresponding to the sticker
     * @var MaskPosition     $mask_position (Optional). A JSON-serialized object for position where the mask should be placed on faces
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function addStickerToSet(array $params): bool
    {
        $response = $this->uploadFile('addStickerToSet', $params, 'png_sticker');

        return $response->getResult();
    }

    /**
     * Move a sticker in a set created by the bot to a specific position.
     *
     * <code>
     * $params = [
     *   'sticker'              => '',
     *   'position'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setstickerpositioninset
     *
     * @param array $params   [
     *
     * @var string  $sticker  Required. File identifier of the sticker
     * @var string  $position Required. New sticker position in the set, zero-based.
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setStickerPositionInSet(array $params): bool
    {
        $response = $this->post('setStickerPositionInSet', $params);

        return $response->getResult();
    }

    /**
     * Delete a sticker from a set created by the bot.
     *
     * <code>
     * $params = [
     *   'sticker'              => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#deletestickerfromset
     *
     * @param array $params   [
     *
     * @var string  $sticker  Required. File identifier of the sticker
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function deleteStickerFromSet(array $params): bool
    {
        $response = $this->post('deleteStickerFromSet', $params);

        return $response->getResult();
    }

    /**
     * Set the thumbnail of a sticker set
     *
     * <code>
     * $params = [
     *   'name'          => '',
     *   'user_id'       => '',
     *   'thumb'         => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setstickersetthumb
     *
     * @param array          $params        [
     *
     * @var string           $name          Required. Sticker set name
     * @var int              $user_id       Required. User identifier of sticker set owner
     * @var InputFile|string $thumb         (Optional). A PNG image with the thumbnail, must be up to 128 kilobytes in size and have width and height exactly 100px, or a TGS animation with the thumbnail up to 32 kilobytes in size; see https://core.telegram.org/animated_stickers#technical-requirements for animated sticker technical requirements. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. More info on Sending Files ». Animated sticker set thumbnail can't be uploaded via HTTP URL
     *
     * ]
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setStickerSetThumb(array $params): bool
    {
        $response = $this->uploadFile('setStickerSetThumb', $params, 'thumb');

        return $response->getResult();
    }

}
