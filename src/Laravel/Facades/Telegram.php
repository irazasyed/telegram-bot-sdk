<?php

namespace Telegram\Bot\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Telegram.
 *
 * // Global methods
 * @method static TelegramClient getClient()
 * @method static string getAccessToken()
 * @method static TelegramResponse getLastResponse()
 * @method static Api setAccessToken($accessToken)
 * @method static Api setAsyncRequest($isAsyncRequest)
 * @method static bool isAsyncRequest()
 * @method static CommandBus getCommandBus()
 *
 * // API methods
 * @method static User getMe()
 * @method static Message sendMessage(array $params)
 * @method static Message forwardMessage(array $params)
 * @method static Message sendPhoto(array $params)
 * @method static Message sendAudio(array $params)
 * @method static Message sendDocument(array $params)
 * @method static Message sendSticker(array $params)
 * @method static Message sendVideo(array $params)
 * @method static Message sendVoice(array $params)
 * @method static Message sendLocation(array $params)
 * @method static Message sendVenue(array $params)
 * @method static Message sendContact(array $params)
 * @method static bool sendChatAction(array $params)
 * @method static UserProfilePhotos getUserProfilePhotos(array $params)
 * @method static File getFile(array $params)
 * @method static bool kickChatMember(array $params)
 * @method static bool unbanChatMember(array $params)
 * @method static Chat getChat(array $params)
 * @method static ChatMember[] getChatAdministrators(array $params)
 * @method static int getChatMembersCount(array $params)
 * @method static ChatMember getChatMember(array $params)
 * @method static bool answerCallbackQuery(array $params)
 * @method static Message|bool editMessageText(array $params)
 * @method static Message|bool editMessageCaption(array $params)
 * @method static Message|bool editMessageReplyMarkup(array $params)
 * @method static bool answerInlineQuery(array $params = [])
 *
 * // Webhook methods
 * @method static TelegramResponse setWebhook(array $params)
 * @method static Update getWebhookUpdate($shouldEmitEvent = true)
 * @method static TelegramResponse removeWebhook()
 *
 * // Updates
 * @method static Update[] getUpdates(array $params = [], $shouldEmitEvents = true)
 *
 * // Command handling
 * @method static Update|Update[] commandsHandler($webhook = false, array $params = [])
 * @method static void processCommand(Update $update)
 * @method static mixed triggerCommand($name, Update $update)
 *
 * // API related
 * @method static Container getContainer()
 * @method static boolean hasContainer()
 * @method static int getTimeOut()
 * @method static Telegram setTimeOut($timeOut)
 * @method static int getConnectTimeOut()
 * @method static Telegram setConnectTimeOut($connectTimeOut)
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
