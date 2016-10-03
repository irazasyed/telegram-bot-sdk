<?php

namespace Telegram\Bot\Tests\Mocks;

use Telegram\Bot\Commands\Command;

/**
 * Class MockCommand
 */
class MockCommand extends Command
{

    protected $name = 'mycommand';

    protected $description = 'a mock command';

    /**
     * MockCommand constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $args
     *
     * @return string
     */
    public function handle($args)
    {
        return 'mycommand handled';
    }
}
