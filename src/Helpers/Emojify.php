<?php

namespace Telegram\Bot\Helpers;

use Telegram\Bot\Exceptions\TelegramEmojiMapFileNotFoundException;

class Emojify
{
    /**
     * The path to the file containing the emoji map.
     *
     * @var string
     */
    const EMOJI_MAP_FILE = '/../Storage/emoji.json';

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
     * Emojify constructor.
     *
     * @param null|string $emojiMapFile
     *
     * @throws TelegramEmojiMapFileNotFoundException
     */
    public function __construct($emojiMapFile = null)
    {
        if (empty($emojiMapFile)) {
            $emojiMapFile = __DIR__.self::EMOJI_MAP_FILE;
        }

        if (!file_exists($emojiMapFile)) {
            throw new TelegramEmojiMapFileNotFoundException();
        }

        $emojiMapFileContents = file_get_contents($emojiMapFile);
        $this->emojiMap = (array)json_decode($emojiMapFileContents);
        $this->wordMap = array_flip($this->emojiMap);
    }

    /**
     * Translate Word to Emoji
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
     * Alias of toEmoji()
     *
     * @param $text
     *
     * @return mixed
     */
    public static function text($text)
    {
        return (new static)->toEmoji($text);
    }

    /**
     * Translate Emoji to Word
     *
     * @param $text
     *
     * @return mixed
     */
    public function toWord($text)
    {
        return $this->replace($text, $this->wordMap, null);
    }

    /**
     * Alias of toWord()
     *
     * @param $text
     *
     * @return mixed
     */
    public static function translate($text)
    {
        return (new static)->toWord($text);
    }

    /**
     * Replace
     *
     * @param        $line
     * @param        $replace
     * @param string $startDelimiter
     *
     * @return mixed
     */
    protected function replace($line, $replace, $startDelimiter = ':')
    {
        uksort($replace, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($replace as $key => $value) {
            $line = str_replace($startDelimiter.$key, $value, $line);
        }

        return $line;
    }
}
