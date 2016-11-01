<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\UserProfilePhotos;

/**
 * Class GetUserProfilePhotos
 *
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
 * @method GetUserProfilePhotos userId($userId) int
 * @method GetUserProfilePhotos offset($offset) int
 * @method GetUserProfilePhotos limit($limit) int
 *
 * @method UserProfilePhotos getResult($dumpAndDie = false)
 */
class GetUserProfilePhotos extends Method
{
    /** {@inheritdoc} */
    protected $getRequest = true;

    /** {@inheritdoc} */
    protected function returns()
    {
        return UserProfilePhotos::class;
    }
}