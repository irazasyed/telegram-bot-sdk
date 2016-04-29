<?php

namespace Telegram\Bot\Conversations;

use Telegram\Bot\Answers\AnswerBus;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;

/**
 * Class ConversationBus
 */
class ConversationBus extends AnswerBus
{
    /**
     * @var Conversation[]
     */
    private $conversations;

    /**
     * ConversationBus constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * @return Conversation[]
     */
    public function getConversations()
    {
        return $this->conversations;
    }

    /**
     * @param array $conversations
     * @return $this
     * @throws TelegramSDKException
     */
    public function addConversations(array $conversations)
    {
        foreach ($conversations as $conversation) {
            $this->addConversation($conversation);
        }

        return $this;
    }

    /**
     * @param $conversation
     * @return $this
     * @throws TelegramSDKException
     */
    public function addConversation($conversation)
    {
        if (!is_object($conversation)) {
            if (!class_exists($conversation)) {
                throw new TelegramSDKException(
                    sprintf(
                        'Conversation class "%s" not found! Please make sure the class exists.',
                        $conversation
                    )
                );
            }

            if ($this->telegram->hasContainer()) {
                $conversation = $this->buildDependencyInjectedAnswer($conversation);
            } else {
                $conversation = new $conversation();
            }
        }

        if ($conversation instanceof ConversationInterface) {
            /*
             * At this stage we definitely have a proper conversation to use.
             *
             * @var Conversation $conversation
            */
            $this->conversations[get_class($conversation)] = $conversation;

            return $this;
        }

        throw new TelegramSDKException(
            sprintf(
                'Conversation class "%s" should be an instance of "Telegram\Bot\Conversations\ConversationInterface"',
                get_class($conversation)
            )
        );
    }

    /**
     * @param $name
     * @return $this
     */
    public function removeConversation($name)
    {
        unset($this->conversations[$name]);

        return $this;
    }

    /**
     * @param array $names
     * @return $this
     */
    public function removeConversations(array $names)
    {
        foreach ($names as $name) {
            $this->removeConversation($name);
        }

        return $this;
    }

    /**
     * Handles Inbound Messages and Executes Appropriate Command.
     *
     * @param $message
     * @param $update
     *
     * @throws TelegramSDKException
     *
     * @return Update
     */
    protected function handler($message, Update $update)
    {
        $this->execute($update->getMessage()->getFrom()->getCurrentConversation(), $update);

        return $update;
    }

    /**
     * Execute the command.
     *
     * @param $name
     * @param $message
     *
     * @return mixed
     */
    protected function execute($name, $update)
    {
        if (array_key_exists($name, $this->conversations)) {
            return $this->conversations[$name]->make($this->telegram, $update);
        }

        return 'Ok';
    }
}