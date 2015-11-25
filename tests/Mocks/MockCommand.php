<?php

namespace Telegram\Tests\Bot\Mocks;

use Telegram\Bot\Commands\Command;

class MockCommand extends Command
{
    protected $name = 'mycommand';

    protected $description = 'a mock command';

    public function handle($args)
    {

    }
}