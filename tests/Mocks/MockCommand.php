<?php

namespace Telegram\Bot\Tests\Mocks;

use Telegram\Bot\Commands\Command;

class MockCommand extends Command
{

    public function __construct()
    {
    }


    protected $name = 'mycommand';

    protected $description = 'a mock command';

    public function handle($args)
    {
        return 'mycommand handled';
    }
}
