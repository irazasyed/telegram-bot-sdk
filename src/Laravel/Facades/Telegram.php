<?php

namespace Telegram\Bot\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Telegram.
 *
 * // Global methods
 * @method static \Telegram\Bot\TelegramClient getClient()
 * @method static string getAccessToken()
 * @method static \Telegram\Bot\TelegramResponse getLastResponse()
 * @method static \Telegram\Bot\Api setAccessToken($accessToken)
 * @method static \Telegram\Bot\Api setAsyncRequest($isAsyncRequest)
 * @method static bool isAsyncRequest()
 * @method static \Telegram\Bot\Commands\CommandBus getCommandBus()
 *
 * // API methods
 * @method static \Telegram\Bot\Objects\User getMe()
 * @method static \Telegram\Bot\Objects\Message sendMessage(array $params)
 * @method static \Telegram\Bot\Objects\Message forwardMessage(array $params)
 * @method static \Telegram\Bot\Objects\Message sendPhoto(array $params)
 * @method static \Telegram\Bot\Objects\Message sendAudio(array $params)
 * @method static \Telegram\Bot\Objects\Message sendDocument(array $params)
 * @method static \Telegram\Bot\Objects\Message sendSticker(array $params)
 * @method static \Telegram\Bot\Objects\Message sendVideo(array $params)
 * @method static \Telegram\Bot\Objects\Message sendVoice(array $params)
 * @method static \Telegram\Bot\Objects\Message sendLocation(array $params)
 * @method static \Telegram\Bot\Objects\Message sendVenue(array $params)
 * @method static \Telegram\Bot\Objects\Message sendContact(array $params)
 * @method static bool sendChatAction(array $params)
 * @method static \Telegram\Bot\Objects\UserProfilePhotos getUserProfilePhotos(array $params)
 * @method static \Telegram\Bot\Objects\File getFile(array $params)
 * @method static bool kickChatMember(array $params)
 * @method static bool unbanChatMember(array $params)
 * @method static \Telegram\Bot\Objects\Chat getChat(array $params)
 * @method static \Telegram\Bot\Objects\ChatMember[] getChatAdministrators(array $params)
 * @method static int getChatMembersCount(array $params)
 * @method static \Telegram\Bot\Objects\ChatMember getChatMember(array $params)
 * @method static bool answerCallbackQuery(array $params)
 * @method static \Telegram\Bot\Objects\Message|bool editMessageText(array $params)
 * @method static \Telegram\Bot\Objects\Message|bool editMessageCaption(array $params)
 * @method static \Telegram\Bot\Objects\Message|bool editMessageReplyMarkup(array $params)
 * @method static bool answerInlineQuery(array $params = [])
 *
 * // Webhook methods
 * @method static \Telegram\Bot\TelegramResponse setWebhook(array $params)
 * @method static \Telegram\Bot\Objects\Update getWebhookUpdate($shouldEmitEvent = true)
 * @method static \Telegram\Bot\TelegramResponse removeWebhook()
 *
 * // Updates
 * @method static \Telegram\Bot\Objects\Update[] getUpdates(array $params = [], $shouldEmitEvents = true)
 *
 * // Command handling
 * @method static \Telegram\Bot\Objects\Update|\Telegram\Bot\Objects\Update[] commandsHandler($webhook = false, array $params = [])
 * @method static void processCommand(Update $update)
 * @method static mixed triggerCommand($name, Update $update)
 *
 * // API related
 * @method static \Illuminate\Contracts\Container\Container getContainer()
 * @method static boolean hasContainer()
 * @method static int getTimeOut()
 * @method static \Telegram\Bot\Api setTimeOut($timeOut)
 * @method static int getConnectTimeOut()
 * @method static \Telegram\Bot\Api setConnectTimeOut($connectTimeOut)
 */
class Telegram extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'telegram';
    }
}
