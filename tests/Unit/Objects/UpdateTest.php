<?php

declare(strict_types=1);

namespace Telegram\Bot\Tests\Unit\Objects;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Update;

/** @covers \Telegram\Bot\Objects\Update */
class UpdateTest extends TestCase
{
    /** @test */
    public function it_parses_chat_relation_for_bot_kicked_event(): void
    {
        $update = new Update([
            // there is no "message" key at this even type!
            'my_chat_member' => [
                'chat' => [
                    'id' => 42,
                    'first_name' => 'Firstname',
                    'last_name' => 'Lastname',
                    'type' => 'private',
                ],
            ],
            'old_chat_member' => [
                'user' => [], // doesn't matter in this case
                'status' => 'member',
            ],
            'new_chat_member' => [
                'user' => [], // doesn't matter in this case
                'status' => 'kicked',
                'until_date' => 0,
            ],
        ]);

        $this->assertInstanceOf(Chat::class, $update->getChat());
    }
}
