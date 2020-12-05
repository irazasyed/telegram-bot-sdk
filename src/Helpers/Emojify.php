<?php

namespace Telegram\Bot\Helpers;

use Telegram\Bot\Exceptions\TelegramEmojiMapFileNotFoundException;

/**
 * Class Emojify.
 */
class Emojify
{
    /**
     * @var Emojify The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * The path to the file containing the emoji map.
     *
     * @var string
     */
    const DEFAULT_EMOJI_MAP_FILE = '/../Storage/emoji.json';

    /**
     * The path to the file containing the emoji map.
     *
     * @var string
     */
    protected $emojiMapFile;

    /**
     * The array mapping words to emoji.
     *
     * @var array
     */
    protected $emojiMap;

    /**
     * The array mapping emoji back to words.
     *
     * @var array
     */
    protected $wordMap;

    /**
     * Protected Emojify constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     *
     * @throws TelegramEmojiMapFileNotFoundException
     */
    protected function __construct()
    {
        $this->setupEmojiMaps();
    }

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Emojify The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Set File Path to Emoji Map File.
     *
     * @param string $emojiMapFile
     *
     * @return Emojify
     */
    public function setEmojiMapFile($emojiMapFile)
    {
        $this->emojiMapFile = $emojiMapFile;
        $this->setupEmojiMaps();

        return $this;
    }

    /**
     * Translate Word to Emoji.
     *
     * @param $text
     *
     * @return mixed
     */
    public function toEmoji($text)
    {
        return $this->replace($text, $this->emojiMap);
    }

    /**
     * Alias of toEmoji().
     *
     * @param $text
     *
     * @return mixed
     */
    public static function text($text)
    {
        return self::getInstance()->toEmoji($text);
    }

    /**
     * Translate Emoji to Word.
     *
     * @param $text
     *
     * @return mixed
     */
    public function toWord($text)
    {
        return $this->replace($text, $this->wordMap, true);
    }

    /**
     * Alias of toWord().
     *
     * @param $text
     *
     * @return mixed
     */
    public static function translate($text)
    {
        return self::getInstance()->toWord($text);
    }

    /**
     * Replace.
     *
     * @param        $line
     * @param        $replace
     * @param bool   $toWord
     * @param string $delimiter
     *
     * @return mixed
     */
    protected function replace($line, $replace, $toWord = false, $delimiter = ':')
    {
        if ($toWord) {
            return $this->emojiToWordReplace($line, $replace, $delimiter);
        }

        return $this->wordToEmojiReplace($line, $replace, $delimiter);
    }

    /**
     * Finds words enclosed by the delimiter and converts them to the
     * appropriate emoji character.
     *
     * @param $line
     * @param $replace
     * @param $delimiter
     *
     * @return mixed
     */
    protected function wordToEmojiReplace($line, $replace, $delimiter)
    {
        foreach ($replace as $key => $value) {
            $line = str_replace($delimiter.$key.$delimiter, $value, $line);
        }

        return $line;
    }

    /**
     * Finds emojis and replaces them with text enclosed by the delimiter.
     *
     * @param $line
     * @param $replace
     * @param $delimiter
     *
     * @return mixed
     */
    protected function emojiToWordReplace($line, $replace, $delimiter)
    {
        foreach ($replace as $key => $value) {
            $line = str_replace($key, $delimiter.$value.$delimiter, $line);
        }

        return $line;
    }

    /**
     * Get Emoji Map Array.
     *
     * @throws TelegramEmojiMapFileNotFoundException
     *
     * @return array
     */
    protected function getEmojiMap()
    {
        if (! isset($this->emojiMapFile)) {
            $this->emojiMapFile = realpath(__DIR__.self::DEFAULT_EMOJI_MAP_FILE);
        }

        if (! file_exists($this->emojiMapFile)) {
            throw new TelegramEmojiMapFileNotFoundException();
        }

        return json_decode(file_get_contents($this->emojiMapFile), true);
    }

    /**
     * Setup Emoji Maps.
     *
     * @throws TelegramEmojiMapFileNotFoundException
     */
    protected function setupEmojiMaps()
    {
        $this->emojiMap = $this->getEmojiMap();
        $this->wordMap = array_flip($this->emojiMap);
    }

    /**
     * Throw an exception when the user tries to clone the *Singleton*
     * instance.
     *
     * @throws \LogicException always
     */
    public function __clone()
    {
        throw new \LogicException('The Emojify helper cannot be cloned');
    }

    /**
     * Throw an exception when the user tries to unserialize the *Singleton*
     * instance.
     *
     * @throws \LogicException always
     */
    public function __wakeup()
    {
        throw new \LogicException('The Emojify helper cannot be serialised');
    }
}
