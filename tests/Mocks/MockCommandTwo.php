<?php

namespace Telegram\Bot\Tests\Mocks;

use Telegram\Bot\Commands\Command;

class MockCommandTwo extends Command
{
    protected $name = 'mycommand2';

    protected $description = 'another mock command';

    public function handle($args)
    {
    }
}
