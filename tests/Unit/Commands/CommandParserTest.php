<?php
declare(strict_types=1);

namespace Telegram\Bot\Tests\Unit\Commands;

use Telegram\Bot\Commands\CommandParser;
use Telegram\Bot\Tests\TestCase;

class CommandParserTest extends TestCase
{
    /** @var CommandParser */
    private $parser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->parser = new CommandParser();
    }

    /** @test */
    public function it_can_return_the_command_name_from_a_message_correctly_ignoring_the_slash()
    {
        $message01 = 'The command is /demo and is in the middle of the string.';
        $message02 = '/beginning command is at the start of a string.';

        $commandName01 = $this->parser->parse($message01, 15, 5);
        $commandName02 = $this->parser->parse($message02, 0, 10);

        $this->assertEquals('demo', $commandName01);
        $this->assertEquals('beginning', $commandName02);
    }

    /** @test */
    public function it_can_parse_a_command_from_a_group_of_bots()
    {
        $message01 = 'The command is /demo@MyDemo_Bot and is in the middle of the string.';
        $message02 = '/demo@MyDemo_Bot command is at the start of a string.';

        $commandName01 = $this->parser->parse($message01, 15, 16);
        $commandName02 = $this->parser->parse($message02, 0, 16);

        $this->assertEquals('demo', $commandName01);
        $this->assertEquals('demo', $commandName02);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_parsing_for_a_command_in_a_message_with_no_text()
    {
        $this->expectException(\InvalidArgumentException::class);
        $message = '';

        $this->parser->parse($message, 5, 5);
    }
}