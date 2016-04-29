<?php

namespace Telegram\Bot\Conversations;

/**
 * Class HelloConversation
 * @package Telegram\Bot\Conversations
 * @author Artiom Mocrenco <tjomamokrenko@gmail.com>
 */
class HelloConversation extends Conversation
{
    /**
     * @inheritdoc
     */
    public function handle()
    {
        $text = \strtolower($this->getUpdate()->getMessage()->getText());

        if ((strpos($text, 'hi') !== false) || (strpos($text, 'hello') !== false)) {
            $this->replyWithMessage(['text' => "Hi, {$this->getUpdate()->getMessage()->getFrom()->getFirstName()}!"]);

            $this
                ->getUpdate()
                ->getMessage()
                ->getFrom()
                ->setCurrentConversation(
                    LeaveMeAloneConversation::class
                );
        }
    }
}
