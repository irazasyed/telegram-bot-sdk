<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\{
    File, User, UserProfilePhotos
};
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class Get
 */
trait Get
{
    /**
     * A simple method for testing your bot's auth token.
     * Returns basic information about the bot in form of a User object.
     *
     * @link https://core.telegram.org/bots/api#getme
     *
     * @throws TelegramSDKException
     *
     * @return User
     */
    public function getMe()
    {
        $response = $this->get('getMe');

        return new User($response->getDecodedBody());
    }

    /**
     * Returns a list of profile pictures for a user.
     *
     * <code>
     * $params = [
     *   'user_id' => '',
     *   'offset'  => '',
     *   'limit'   => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getuserprofilephotos
     *
     * @param array $params
     *
     * @var int     $params ['user_id']
     * @var int     $params ['offset']
     * @var int     $params ['limit']
     *
     * @throws TelegramSDKException
     *
     * @return UserProfilePhotos
     */
    public function getUserProfilePhotos(array $params)
    {
        $response = $this->get('getUserProfilePhotos', $params);

        return new UserProfilePhotos($response->getDecodedBody());
    }

    /**
     * Returns basic info about a file and prepare it for downloading.
     *
     * <code>
     * $params = [
     *   'file_id' => '',
     * ];
     * </code>
     *
     * The file can then be downloaded via the link
     * https://api.telegram.org/file/bot<token>/<file_path>,
     * where <file_path> is taken from the response.
     *
     * @link https://core.telegram.org/bots/api#getFile
     *
     * @param array $params
     *
     * @var string  $params ['file_id']
     *
     * @throws TelegramSDKException
     *
     * @return File
     */
    public function getFile(array $params)
    {
        $response = $this->get('getFile', $params);

        return new File($response->getDecodedBody());
    }
}