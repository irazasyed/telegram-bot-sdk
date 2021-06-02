<?php
declare(strict_types=1);

namespace Telegram\Bot\Tests\Unit\Commands;

use Telegram\Bot\Commands\BotCommandsProcessor;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Tests\TestCase;

class BotCommandsProcessorTest extends TestCase
{
    /** @var BotCommandsProcessor */
    private $processor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->processor = new BotCommandsProcessor();
    }

    /** @test */
    public function it_bot_command_should_return_parsed_data()
    {
        $update = new Update([
            'message' => [
                'text'     => 'This /demo',
                'entities' => [
                    [
                        'type'   => 'bot_command',
                        'offset' => 5,
                        'length' => 5,
                    ],
                ],
            ],
        ]);

        $results = $this->processor->handle($update);

        $this->assertEquals([
            'demo' => [
                'type'   => 'bot_command',
                'offset' => 5,
                'length' => 5,
            ]
        ], $results);
    }

    /** @test */
    public function it_not_a_bot_command_should_return_empty_array()
    {
        $update = new Update([
            'message' => [
                'text'     => 'This demo',
                'entities' => [
                    [
                        'type'   => 'not_bot_command',
                        'offset' => 5,
                        'length' => 5,
                    ],
                ],
            ],
        ]);

        $results = $this->processor->handle($update);

        $this->assertEquals([], $results);
    }
}