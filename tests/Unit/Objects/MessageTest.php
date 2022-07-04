<?php

namespace Telegram\Bot\Tests\Unit\Objects;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\PhotoSize;

/** @covers \Telegram\Bot\Objects\Message */
class MessageTest extends TestCase
{
    /** @test */
    public function it_inits_one_to_many_relation(): void
    {
        $message = Message::make([
            'photo' => [
                ['file_id' => ''],
                ['file_id' => ''],
                ['file_id' => ''],
                ['file_id' => ''],
            ],
        ]);

        $this->assertIsIterable($message->photo);
        $this->assertCount(4, $message->photo);
        $this->assertInstanceOf(PhotoSize::class, $message->photo[0]);
        $this->assertInstanceOf(PhotoSize::class, $message->photo[1]);
        $this->assertInstanceOf(PhotoSize::class, $message->photo[2]);
        $this->assertInstanceOf(PhotoSize::class, $message->photo[3]);
    }
}
