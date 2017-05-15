<?php

namespace Telegram\Bot\Tests\Unit\Commands;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Commands\Command;

class CommandTest extends TestCase
{
    protected $api;
    /**
     * @var Command
     */
    protected $command;

    protected function setUp()
    {
        parent::setUp();
        $this->api = $this->prophesize(Api::class)->reveal();
        $this->command = $this->getMockForAbstractClass(Command::class)
            ->setName('demo')
            ->setPattern('{fname} {lastname}');
    }

    /** @test */
    public function a_command_with_no_pattern_set_will_have_an_empty_argument_array()
    {
        //Condensed update data
        $update = new Update([
            "message" => [
                "text"     => "This /demo john ",
                "entities" => [
                    [
                        "type"   => "bot_command",
                        "offset" => 5,
                        "length" => 5,
                    ],
                ],
            ],
        ]);

        $command = $this->getMockForAbstractClass(Command::class)
            ->setName('demo');

        $entity = $update->getMessage()->entities->get(0)->toArray();
        $command->make($this->api, $update, $entity);
        $this->assertEquals([], $command->getArguments());
    }

    /** @test */
    public function it_returns_empty_values_if_no_text_other_that_command_is_found()
    {
        //Condensed update data
        $update = new Update([
            "message" => [
                "text"     => "/demo",
                "entities" => [
                    [
                        "type"   => "bot_command",
                        "offset" => 0,
                        "length" => 5,
                    ],
                ],
            ],
        ]);

        //First time the command is triggered for entity "0"
        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->make($this->api, $update, $entity);
        $this->assertEquals(['fname' => '', 'lastname' => ''], $this->command->getArguments());
    }

    /** @test */
    public function it_returns_empty_values_if_too_many_arguments_have_been_specified_compared_to_text_received()
    {
        //Condensed update data
        $update = new Update([
            "message" => [
                "text"     => "This /demo john ",
                "entities" => [
                    [
                        "type"   => "bot_command",
                        "offset" => 5,
                        "length" => 5,
                    ],
                ],
            ],
        ]);

        //First time the command is triggered for entity "0"
        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->make($this->api, $update, $entity);
        $this->assertEquals(['fname' => 'john', 'lastname' => ''], $this->command->getArguments());
    }

    /** @test */
    public function it_checks_the_arguments_can_be_detected_in_a_message_with_multiple_commands_that_are_the_same()
    {
        //Condensed update data
        $update = new Update([
            "message" => [
                "text"     => "This /demo john doe command with /demo jane doe and a unrelated /test command",
                "entities" => [
                    [
                        "type"   => "bot_command",
                        "offset" => 5,
                        "length" => 5,
                    ],
                    [
                        "type"   => "bot_command",
                        "offset" => 33,
                        "length" => 5,
                    ],
                    [
                        "type"   => "bot_command",
                        "offset" => 64,
                        "length" => 5,
                    ],
                ],
            ],
        ]);

        //First time the command is triggered for entity "0"
        $entity0 = $update->getMessage()->entities->get(0)->toArray();
        $this->command->make($this->api, $update, $entity0);
        $this->assertEquals(['fname' => 'john', 'lastname' => 'doe'], $this->command->getArguments());

        //Second time the command is triggered for entity "1"
        $entity1 = $update->getMessage()->entities->get(1)->toArray();
        $this->command->make($this->api, $update, $entity1);
        $this->assertEquals(['fname' => 'jane', 'lastname' => 'doe'], $this->command->getArguments());

        //This command should not be triggered for entity "2". But if it is, the arguments should be blank.
        $entity2 = $update->getMessage()->entities->get(2)->toArray();
        $this->command->make($this->api, $update, $entity2);
        $this->assertEquals(['fname' => '', 'lastname' => ''], $this->command->getArguments());
    }
}
