<?php

namespace Telegram\Bot\Answers;

use BadMethodCallException;
use Illuminate\Support\Str;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Traits\Telegram;

/**
 * Class Answerable.
 *
 * @method mixed replyWithMessage($use_sendMessage_parameters)       Reply Chat with a message. You can use all the sendMessage() parameters except chat_id.
 * @method mixed replyWithPhoto($use_sendPhoto_parameters)           Reply Chat with a Photo. You can use all the sendPhoto() parameters except chat_id.
 * @method mixed replyWithAudio($use_sendAudio_parameters)           Reply Chat with an Audio message. You can use all the sendAudio() parameters except chat_id.
 * @method mixed replyWithVideo($use_sendVideo_parameters)           Reply Chat with a Video. You can use all the sendVideo() parameters except chat_id.
 * @method mixed replyWithVoice($use_sendVoice_parameters)           Reply Chat with a Voice message. You can use all the sendVoice() parameters except chat_id.
 * @method mixed replyWithDocument($use_sendDocument_parameters)     Reply Chat with a Document. You can use all the sendDocument() parameters except chat_id.
 * @method mixed replyWithSticker($use_sendSticker_parameters)       Reply Chat with a Sticker. You can use all the sendSticker() parameters except chat_id.
 * @method mixed replyWithLocation($use_sendLocation_parameters)     Reply Chat with a Location. You can use all the sendLocation() parameters except chat_id.
 * @method mixed replyWithChatAction($use_sendChatAction_parameters) Reply Chat with a Chat Action. You can use all the sendChatAction() parameters except chat_id.
 */
trait Answerable
{
    use Telegram;

    /**
     * @var Update Holds an Update object.
     */
    protected Update $update;

    /**
     * Magic Method to handle all ReplyWith Methods.
     *
     * @return mixed|string
     */
    public function __call(string $method, array $parameters)
    {
        if (! Str::startsWith($method, 'replyWith')) {
            throw new BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
        }

        $replyName = Str::studly(substr($method, 9));
        $methodName = 'send'.$replyName;

        if (! method_exists($this->telegram, $methodName)) {
            throw new BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
        }

        $chatId = $this->update->getChat()->id ?? null;
        if (! $chatId) {
            throw new BadMethodCallException(sprintf('No chat available for reply with [%s].', $method));
        }

        $params = array_merge(['chat_id' => $chatId], $parameters[0]);

        return $this->telegram->{$methodName}($params);
    }

    /**
     * Returns Update object.
     */
    public function getUpdate(): Update
    {
        return $this->update;
    }
}
