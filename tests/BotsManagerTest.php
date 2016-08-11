<?php

namespace Telegram\Bot\Tests;

use PHPUnit_Framework_TestCase;
use Telegram\Bot\Bots\Bot;
use Telegram\Bot\Bots\BotsManager;
use Telegram\Bot\Commands\CommandBot;


class BotsManagerTest extends PHPUnit_Framework_TestCase
{
    
    var $testConfig = [    
        'default' => 'defaultbot',

        'bots' => [
            'defaultbot' => [
                'username'  => 'defaultbotname',
                'token' => '12345',
                'commands' => [],
                'use_emojify' => true,
            ],
        ],

        'async_requests' => false,

        'http_client_handler' => null,

        'resolve_command_dependencies' => true,

        'commands' => [
            \Telegram\Bot\Commands\HelpCommand::class,
        ],

        'command_groups' => [],

        'shared_commands' => [],
    ];
    
    /**
     * @var BotsManager
     */
    protected $manager;

    public function setUp()
    {
        $this->manager = new BotsManager($this->testConfig);
    }

    /** @test */
    public function it_checks_the_config_gets_read()
    {
        $config = $this->testConfig['bots'][$this->testConfig['default']];
        $config['bot'] = $this->testConfig['default'];
        
        $this->assertEquals(
            $config,
            $this->manager->getBotConfig()
        );        
    }
    
    /** @test */
    public function it_checks_the_bot_instance_gets_created_and_stored(){
        $bot1 = $this->manager->bot();
        $this->assertInstanceOf(Bot::class, $bot1);
        
        $bot2 = $this->manager->bot();
        $this->assertEquals($bot2, $bot1);        
    }
    
    /** @test */
    public function it_checks_the_command_gets_added(){
        $bot = $this->manager->bot();
        $this->assertInstanceOf(CommandBot::class, $bot);
        
        $command = $bot->getCommands()['help'];
        $this->assertInstanceOf(\Telegram\Bot\Commands\HelpCommand::class, $command);
        
    }
    
}
