<?php

namespace Telegram\Bot\Tests;

use ReflectionClass;
use Telegram\Bot\Helpers\Emojify;

class EmojiSupportTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramEmojiMapFileNotFoundException
     **/
    public function it_throws_exception_when_missing_emoji_map_is_used()
    {
        Emojify::getInstance()->setEmojiMapFile('wrong_file.json');
    }

    /** @test */
    public function it_ensures_the_default_emoji_file_is_available()
    {
        $emoji = Emojify::getInstance();

        // If we can assert the instant is of the correct type, then no exception
        // was thrown during it's creation. A valid emoji file is required
        // during creation.
        $this->assertInstanceOf(Emojify::class, $emoji);
    }

    /** @test */
    public function it_replaces_a_keyword_with_an_emoji()
    {
        $plainText = 'This works! :smile:';
        $emojiText = Emojify::text($plainText);

        $this->assertContains('😄', $emojiText);
    }

    /** @test */
    public function it_requires_the_keyword_to_be_enclosed_with_a_delimiter()
    {
        $plainText = 'This should not work! :smile';
        $emojiText = Emojify::text($plainText);

        $this->assertNotContains('😄', $emojiText);
        $this->assertContains(':smile', $emojiText);
    }

    /** @test * */
    public function it_replaces_an_emoji_with_its_keyword()
    {
        $plainText = 'This works! 😄';
        $emojiText = Emojify::translate($plainText);

        $this->assertContains(':smile:', $emojiText);
    }

    /** @test * */
    public function it_ensures_a_replaced_emoji_is_enclosed_with_a_delimiter()
    {
        $plainText = 'This  😄 works!';
        $emojiText = Emojify::translate($plainText);

        $this->assertContains(':smile:', $emojiText);
        $this->assertNotContains(' smile ', $emojiText);
    }

    /**
     * Reset the Singleton so that previous test doesn't interfere with
     * the next one.
     */
    protected function tearDown()
    {
        $reflection = new ReflectionClass(Emojify::class);
        $property = $reflection->getProperty("instance");
        $property->setAccessible(true); // instance is gone
        $property->setValue(null);// now we can modify that :)
        $property->setAccessible(false); // clean up
    }
}
