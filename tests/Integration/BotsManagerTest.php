<?php

namespace Telegram\Bot\Tests\Integration;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Telegram\Bot\BotsManager;

class BotsManagerTest extends TestCase
{
    /**
     * @var BotsManager
     */
    protected $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->manager = new BotsManager(
            [
                'default'                      => 'bot1',
                'bots'                         => [
                    'bot1' => [
                        'username' => 'BotOne_Bot',
                        'token'    => 'TOKEN1',
                        'commands' => [],
                    ],
                    'bot2' => [
                        'username' => 'BotTwo_Bot',
                        'token'    => 'TOKEN2',
                        'commands' => [],
                    ],
                    'bot3' => [
                        'username' => 'BotThree_Bot',
                        'token'    => 'TOKEN3',
                        'commands' => [],
                    ],
                ],
                'resolve_command_dependencies' => true,
                'commands'                     => [
                    //      Telegram\Bot\Commands\HelpCommand::class,
                ],
            ]
        );
    }

    /** @test a bots manager can be created */
    public function a_bots_manager_can_be_created_with_no_config()
    {
        $manager = new BotsManager([]);

        $this->assertInstanceOf(BotsManager::class, $manager);
    }

    /**
     * @test
     */
    public function a_bot_must_be_configured_before_it_can_be_used()
    {
        $this->expectException(InvalidArgumentException::class);

        $manager = new BotsManager([]);
        $manager->bot('demo');
    }

    /** @test an invalid config paramters returns null */
    public function an_invalid_or_missing_config_parameter_returns_null()
    {
        $manager = new BotsManager([]);

        $name = $manager->getDefaultBotName();

        $this->assertNull($name);
    }

    /** @test */
    public function it_is_possible_to_remove_a_bot_from_the_manager_but_leave_the_others()
    {
        $bot1 = $this->manager->bot('bot1');
        $bot2 = $this->manager->bot('bot2');
        $bot3 = $this->manager->bot('bot3');

        $this->assertCount(3, $this->manager->getBots());

        $this->manager->disconnect('bot2');
        $remainingBots = $this->manager->getBots();

        $this->assertCount(2, $remainingBots);
        $this->assertArrayNotHasKey('bot2', $remainingBots);
        $this->assertArrayHasKey('bot1', $remainingBots);
        $this->assertArrayHasKey('bot3', $remainingBots);
    }

    /** @test */
    public function it_is_possible_to_reconnect_a_bot_that_was_disconnected_or_not_used_yet()
    {
        $this->assertCount(0, $this->manager->getBots());

        $this->manager->reconnect('bot1');

        $this->assertCount(1, $this->manager->getBots());
        $this->assertArrayHasKey('bot1', $this->manager->getBots());
    }

    /** @test Duplicated commands dont cause a problem */
    public function duplicated_commands_dont_cause_a_problem()
    {
        $manager = new BotsManager(
            [
                'commands'        => [
                    'Acme\Project\Commands\Command1',
                ],
                'shared_commands' => [
                    'start'  => 'Acme\Project\Commands\StartCommand',
                    'stop'   => 'Acme\Project\Commands\StopCommand',
                    'status' => 'Acme\Project\Commands\StatusCommand',
                ],
                'command_groups'  => [
                    'common'       => [
                        'Acme\Project\Commands\TodoCommand',
                        'Acme\Project\Commands\TaskCommand',
                        'Acme\Project\Commands\Command2',
                    ],
                    'subscription' => [
                        'start',
                        'stop',
                    ],
                    'parentgroup'  => [
                        'common',
                        'subscription',
                    ],
                    'myBot'        => [
                        'admin', // Command Group Name.
                        'subscription', // Command Group Name.
                        'status', // Shared Command Name.
                        'Acme\Project\Commands\BotCommand', // Full Path to Command Class.
                    ],
                ],
            ]
        );

        $commands01 = $manager->parseBotCommands([
            'Acme\Project\Commands\Command1',
            'Acme\Project\Commands\Command2',
            'Acme\Project\Commands\Command3',
        ]);

        $commands02 = $manager->parseBotCommands([
            'Acme\Project\Commands\Command2',
            'Acme\Project\Commands\Command3',
            'common',
        ]);

        $commands03 = $manager->parseBotCommands([
            'Acme\Project\Commands\Command1',
            'Acme\Project\Commands\Command2',
            'Acme\Project\Commands\Command3',
            'start',
            'stop',
            'subscription',
        ]);

        $commands04 = $manager->parseBotCommands([
            'Acme\Project\Commands\Command1',
            'Acme\Project\Commands\Command2',
            'Acme\Project\Commands\Command3',
            'parentgroup',
        ]);

        $commands05 = $manager->parseBotCommands([
            'Acme\Project\Commands\Command1',
            'Acme\Project\Commands\Command2',
            'Acme\Project\Commands\Command3',
            'myBot',
        ]);

        $this->assertCount(3, $commands01);
        $this->assertCount(5, $commands02);
        $this->assertCount(5, $commands03);
        $this->assertCount(7, $commands04);
        $this->assertCount(8, $commands05);
    }
}
