<?php

namespace Telegram\Bot\Objects;

use bar\baz\source_with_namespace;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\SQLite3Cache;
use Telegram\Bot\Conversations\Conversation;
use Telegram\Bot\Conversations\HelloConversation;

/**
 * Class User.
 *
 *
 * @method int      getId()         Unique identifier for this user or bot.
 * @method string   getFirstName()  User's or bot's first name.
 * @method string   getLastName()   (Optional). User's or bot's last name.
 * @method string   getUsername()   (Optional). User's or bot's username.
 */
class User extends BaseObject
{
    /**
     * @var string $currentConversation
     */
    private $currentConversation;

    /**
     * @var SQLite3Cache $cache
     */
    private $cache;

    /**
     * @inheritdoc
     */
    public function __construct($data)
    {
        parent::__construct($data);

        $this->cache = new FilesystemCache(__DIR__.'/../Storage/cache');
    }

    /**
     * @return string
     */
    public function getCurrentConversation()
    {
        if (is_null($this->currentConversation)) {
            $cacheId = $this->getId() . '_current_conversation';
            if (($currentConversation = $this->cache->fetch($cacheId)) !== false) {
                $this->currentConversation = $currentConversation;

                return $currentConversation;
            };

            $this->setCurrentConversation(HelloConversation::class);
        }

        return $this->currentConversation;
    }

    /**
     * @param string $currentConversation
     */
    public function setCurrentConversation($currentConversation)
    {
        $cacheId = $this->getId() . '_current_conversation';
        
        $this->cache->save($cacheId, $currentConversation);
        
        $this->currentConversation = $currentConversation;
    }

    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
