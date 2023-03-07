<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\File;
use Telegram\Bot\Objects\Message as MessageObject;
use Telegram\Bot\Objects\StickerSet;
use Telegram\Bot\Traits\Http;

/**
 * Class Message.
 *
 * @mixin Http
 */
trait Stickers
{
    /**
     * Use this method to send static .WEBP or animated .TGS stickers.
     *
     * <code>
     * $params = [
     *       'chat_id'                      => '',                      // int|string       - Required. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'sticker'                      => InputFile::file($file),  // InputFile|string - Required. Sticker to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a .webp file from the Internet, or upload a new one using multipart/form-data.
     *       'disable_notification'         => '',                      // bool             - (Optional). Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     *       'protect_content'              => '',                      // bool             - (Optional). Protects the contents of the sent message from forwarding and saving
     *       'reply_to_message_id'          => '',                      // int              - (Optional). If the message is a reply, ID of the original message
     *       'allow_sending_without_reply   => '',                      // bool             - (Optional). Pass True, if the message should be sent even if the specified replied-to message is not found
     *       'reply_markup'                 => '',                      // string           - (Optional). Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendsticker
     *
     * @throws TelegramSDKException
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
     *       'name'  => '',  // string - Required. Name of the sticker set
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getstickerset
     *
     * @throws TelegramSDKException
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
     *       'user_id'      => '',                      // int       - Required. Unique identifier for the target chat or username of the target channel (in the format "@channelusername")
     *       'png_sticker'  => InputFile::file($file),  // InputFile - Required. Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#uploadstickerfile
     *
     * @throws TelegramSDKException
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
     *       'user_id'         => '',                           // int              - Required. User identifier of created sticker set owner
     *       'name'            => '',                           // string           - Required. Short name of sticker set, to be used in t.me/addstickers/ URLs (e.g., animals). Can contain only english letters, digits and underscores. Must begin with a letter, can't contain consecutive underscores and must end in “_by_<bot username>”. <bot_username> is case insensitive. 1-64 characters.
     *       'title'           => '',                           // string           - Required. Sticker set title, 1-64 characters
     *       'png_sticker'     => InputFile::file($file),       // InputFile|string - (Optional). Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data.
     *       'tgs_sticker'     => InputFile::file($file),       // InputFile        - (Optional). TGS animation with the sticker, uploaded using multipart/form-data. See https://core.telegram.org/animated_stickers#technical-requirements for technical requirements
     *       'emojis'          => '',                           // string           - Required. One or more emoji corresponding to the sticker
     *       'contains_masks'  => '',                           // bool             - (Optional). Pass True, if a set of mask stickers should be created
     *       'mask_position'   => MaskPosition::make($fields),  // MaskPosition     - (Optional). A JSON-serialized object for position where the mask should be placed on faces
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#createnewstickerset
     *
     * @throws TelegramSDKException
     */
    public function createNewStickerSet(array $params): bool
    {
        return $this->uploadFile('createNewStickerSet', $params, 'png_sticker')->getResult();
    }

    /**
     * Add a new sticker to a set created by the bot.
     *
     * <code>
     * $params = [
     *       'user_id'        => '',                           // int              - Required. User identifier of sticker set owner
     *       'name'           => '',                           // string           - Required. Sticker set name
     *       'png_sticker'    => InputFile::file($file),       // InputFile|string - Required. Png image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data.
     *       'tgs_sticker'    => InputFile::file($file),       // InputFile        - (Optional). TGS animation with the sticker, uploaded using multipart/form-data. See https://core.telegram.org/animated_stickers#technical-requirements for technical requirements
     *       'emojis'         => '',                           // string           - Required. One or more emoji corresponding to the sticker
     *       'mask_position'  => MaskPosition::make($fields),  // MaskPosition     - (Optional). A JSON-serialized object for position where the mask should be placed on faces
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#addstickertoset
     *
     * @throws TelegramSDKException
     */
    public function addStickerToSet(array $params): bool
    {
        return $this->uploadFile('addStickerToSet', $params, 'png_sticker')->getResult();
    }

    /**
     * Move a sticker in a set created by the bot to a specific position.
     *
     * <code>
     * $params = [
     *       'sticker'   => '',  // string - Required. File identifier of the sticker
     *       'position'  => '',  // string - Required. New sticker position in the set, zero-based.
     * ]
     * </code>
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
     * <code>
     * $params = [
     *       'sticker'  => '',  // string - Required. File identifier of the sticker
     * ]
     * </code>
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
     * Set the thumbnail of a sticker set
     *
     * <code>
     * $params = [
     *       'name'     => '',                      // string           - Required. Sticker set name
     *       'user_id'  => '',                      // int              - Required. User identifier of sticker set owner
     *       'thumb'    => InputFile::file($file),  // InputFile|string - (Optional). A PNG image with the thumbnail, must be up to 128 kilobytes in size and have width and height exactly 100px, or a TGS animation with the thumbnail up to 32 kilobytes in size; see https://core.telegram.org/animated_stickers#technical-requirements for animated sticker technical requirements. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. More info on Sending Files ». Animated sticker set thumbnail can't be uploaded via HTTP URL
     * ]
     *
     * @link https://core.telegram.org/bots/api#setstickersetthumb
     * </code>
     *
     * @throws TelegramSDKException
     */
    public function setStickerSetThumb(array $params): bool
    {
        return $this->uploadFile('setStickerSetThumb', $params, 'thumb')->getResult();
    }
}
