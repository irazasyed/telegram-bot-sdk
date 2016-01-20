<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Api;
use Telegram\Bot\Helpers\Emojify;
use Telegram\Bot\Exceptions\TelegramEmojiMapFileNotFoundException;

class EmojiSupportTest extends \PHPUnit_Framework_TestCase
{
  
  public function setUp()
  {
    $this->emojify = new Emojify();
  }
  
  /** @test
   *  @expectedException \Telegram\Bot\Exceptions\TelegramEmojiMapFileNotFoundException
   **/
  public function wrong_emoji_map_passed_to_constructor()
  {
    new Emojify('wrong_file.json');
  }
  
  /** @test **/
  public function replace_word_by_emoji()
  {
    $plainText = 'This works! :smile';
    $emojiText = $this->emojify->toEmoji($plainText);
    $this->assertContains('😄', $emojiText);
  }
  
  /** @test **/
  public function replace_emoji_by_word()
  {
    $plainText = 'This works! 😄';
    $emojiText = $this->emojify->toWord($plainText);
    $this->assertContains('smile', $emojiText);
  }
}