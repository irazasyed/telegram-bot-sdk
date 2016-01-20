<?php 

namespace Telegram\Bot\Helpers;

use Telegram\Bot\Exceptions\TelegramEmojiMapFileNotFoundException;

class Emojify
{
  /**
   * The path to the file containing the emoji map
   * @var string
   */
  const EMOJI_MAP_FILE = '/../Storage/emoji.json';
  
  /**
   * The object mapping the emoji to words
   * @var object
   */
  protected $emojiMap;
  
  public function __construct($emojiMapFile = null) 
  {
    if (empty($emojiMapFile)) {
      $emojiMapFile = __DIR__ . self::EMOJI_MAP_FILE;
    }
    if (!file_exists($emojiMapFile)) {
      throw new TelegramEmojiMapFileNotFoundException();
    }
    $emojiMapFileContents = file_get_contents($emojiMapFile);
    $this->emojiMap = (array) json_decode($emojiMapFileContents);
    $this->wordMap = array_flip($this->emojiMap);
  }
  
  public function toEmoji($text) {
    return $this->replace($text, $this->emojiMap);
  }
  
  public function toWord($text) {
    return $this->replace($text, $this->wordMap, null);
  }
  
  protected function replace($line, $replace, $startDelimiter = ':') {
    uksort($replace, function($a, $b) {
      return strlen($b) - strlen($a);
    });

    foreach ($replace as $key => $value) {
        $line = str_replace($startDelimiter.$key, $value, $line);
    }

    return $line;
  }
}

