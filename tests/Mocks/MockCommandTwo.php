<?php

namespace Telegram\Bot\Tests\Mocks;

use Telegram\Bot\Commands\Command;

/**
 * Class MockCommandTwo
 */
class MockCommandTwo extends Command
{
    protected $name = 'mycommand2';

    protected $description = 'another mock command';

    /**
     * @param $args
     */
    public function handle($args)
    {
    }
}
