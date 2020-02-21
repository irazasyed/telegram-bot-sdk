<?php

namespace Telegram\Bot\Tests\Unit\Commands;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Api;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Update;

class CommandTest extends TestCase
{
    protected $api;
    /**
     * @var Command
     */
    protected $command;

    protected function setUp(): void
    {
        parent::setUp();
        $this->api = $this->prophesize(Api::class)->reveal();
        $this->command = $this->getMockForAbstractClass(Command::class)
            ->setName('demo');
    }

    /** @test */
    public function a_command_with_no_pattern_set_will_return_an_empty_argument_array()
    {
        //Condensed update data
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

        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->setPattern('');

        $this->command->make($this->api, $update, $entity);

        $this->assertEquals([], $this->command->getArguments());
    }

    /** @test */
    public function a_command_with_no_pattern_set_but_has_text_after_the_command_will_return_an_empty_argument_array()
    {
        //Condensed update data
        $update = new Update([
            'message' => [
                'text'     => '/demo@testing_Bot John Doe',
                'entities' => [
                    [
                        'type'   => 'bot_command',
                        'offset' => 0,
                        'length' => 17,
                    ],
                ],
            ],
        ]);
        $this->command->setPattern('');
        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->setPattern('');

        $this->command->make($this->api, $update, $entity);

        $this->assertEquals([], $this->command->getArguments());
    }

    /** @test */
    public function a_command_with_only_required_pattern_variables_is_parsed_correctly()
    {
        //Condensed update data
        $update = new Update([
            'message' => [
                'text'     => '/demo@testing_Bot John Doe 77 200',
                'entities' => [
                    [
                        'type'   => 'bot_command',
                        'offset' => 0,
                        'length' => 17,
                    ],
                ],
            ],
        ]);
        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->setPattern('{fname} {lname} {age} {weight}');

        $this->command->make($this->api, $update, $entity);

        $this->assertEquals(
            ['fname' => 'John', 'lname' => 'Doe', 'age' => '77', 'weight' => '200'],
            $this->command->getArguments()
        );
    }

    /** @test */
    public function a_command_with_required_and_optional_pattern_variables_is_parsed_correctly()
    {
        //Condensed update data
        $update = new Update([
            'message' => [
                'text'     => '/demo@testing_Bot John Doe 77 200',
                'entities' => [
                    [
                        'type'   => 'bot_command',
                        'offset' => 0,
                        'length' => 17,
                    ],
                ],
            ],
        ]);
        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->setPattern('{fname} {lname} {age?} {weight?}');

        $this->command->make($this->api, $update, $entity);

        $this->assertEquals(
            ['fname' => 'John', 'lname' => 'Doe', 'age' => '77', 'weight' => '200'],
            $this->command->getArguments()
        );
    }

    /** @test */
    public function a_command_with_more_required_pattern_variables_than_exists_in_update_message_is_not_matched()
    {
        //Condensed update data
        $update = new Update([
            'message' => [
                'text'     => '/demo@testing_Bot John Doe 77',
                'entities' => [
                    [
                        'type'   => 'bot_command',
                        'offset' => 0,
                        'length' => 17,
                    ],
                ],
            ],
        ]);
        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->setPattern('{fname} {lname} {age} {weight}');

        $this->command->make($this->api, $update, $entity);

        $this->assertEquals([], $this->command->getArguments());
    }

    /** @test */
    public function a_command_with_custom_regex_set_as_pattern_will_return_an_array_with_the_match_value()
    {
        //Condensed update data
        $update = new Update([
            'message' => [
                'text'     => '/demo@testing_Bot eidw einn egaa egcc',
                'entities' => [
                    [
                        'type'   => 'bot_command',
                        'offset' => 0,
                        'length' => 17,
                    ],
                ],
            ],
        ]);
        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->setPattern('.+');

        $this->command->make($this->api, $update, $entity);

        $this->assertEquals(['custom' => 'eidw einn egaa egcc'], $this->command->getArguments());
    }

    /** @test */
    public function a_command_with_more_advance_custom_regex_set_as_pattern_will_return_an_array_with_the_match_value()
    {
        //Condensed update data
        $update = new Update([
            'message' => [
                'text'     => '/demo@testing_Bot ei105 22/03/2017',
                'entities' => [
                    [
                        'type'   => 'bot_command',
                        'offset' => 0,
                        'length' => 17,
                    ],
                ],
            ],
        ]);
        $entity = $update->getMessage()->entities->get(0)->toArray();
        $this->command->setPattern('[a-z]{2}\d{3}\s+?\d{2}/\d{2}/\d{2,4}');

        $this->command->make($this->api, $update, $entity);

        $this->assertEquals(['custom' => 'ei105 22/03/2017'], $this->command->getArguments());
    }

    /** @test */
    public function it_checks_the_arguments_can_be_detected_in_a_message_with_multiple_commands_that_are_the_same()
    {
        //Condensed update data
        $update = new Update([
            'message' => [
                'text'     => 'This /demo john doe command with /demo jane doe and a unrelated /test command',
                'entities' => [
                    [
                        'type'   => 'bot_command',
                        'offset' => 5,
                        'length' => 5,
                    ],
                    [
                        'type'   => 'bot_command',
                        'offset' => 33,
                        'length' => 5,
                    ],
                    [
                        'type'   => 'bot_command',
                        'offset' => 64,
                        'length' => 5,
                    ],
                ],
            ],
        ]);

        $this->command->setPattern('{fname} {lname}');

        //First time the command is triggered for entity "0"
        $entity0 = $update->getMessage()->entities->get(0)->toArray();
        $this->command->make($this->api, $update, $entity0);
        $this->assertEquals(['fname' => 'john', 'lname' => 'doe'], $this->command->getArguments());

        //Second time the command is triggered for entity "1"
        $entity1 = $update->getMessage()->entities->get(1)->toArray();
        $this->command->make($this->api, $update, $entity1);
        $this->assertEquals(['fname' => 'jane', 'lname' => 'doe'], $this->command->getArguments());

        //This command should not be triggered for entity "2". But if it is, the arguments should be blank.
        $entity2 = $update->getMessage()->entities->get(2)->toArray();
        $this->command->make($this->api, $update, $entity2);
        $this->assertEquals([], $this->command->getArguments());
    }
}
