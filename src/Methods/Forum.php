<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message as MessageObject;
use Telegram\Bot\Traits\Http;

/**
 * Class Message.
 *
 * @mixin Http
 */
trait Forum
{
    /**
     * Create forum topics.
     *
     * <code>
     * $params = [
     *       'chat_id'                     => '',  // int|string - Required. Unique identifier for the target chat or username of the target supergroup (in the format @supergroupusername)
     *       'name'                        => '',  // string     - Required. Topic name, 1-128 characters
     *       'icon_color'                  => '',  // int        - (Optional). Color of the topic icon in RGB format. Currently, must be one of 7322096 (0x6FB9F0), 16766590 (0xFFD67E), 13338331 (0xCB86DB), 9367192 (0x8EEE98), 16749490 (0xFF93B2), or 16478047 (0xFB6F5F)
     *       'icon_custom_emoji_id'        => '',  // string     - (Optional). Unique identifier of the custom emoji shown as the topic icon. Use getForumTopicIconStickers to get all allowed custom emoji identifiers.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#createforumtopic
     *
     * @throws TelegramSDKException
     */
    public function createForumTopic(array $params): MessageObject
    {
        $response = $this->post('createForumTopic', $params);

        return new MessageObject($response->getDecodedBody());
    }
}
