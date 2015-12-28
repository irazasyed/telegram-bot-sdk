<?php

namespace Telegram\Bot\Tests\Mocks;

use Telegram\Bot\Commands\Command;

class MockCommandWithDependency extends Command
{

    /**
     * @var \stdClass
     */
    protected $stdClass;

    public function __construct(\stdClass $stdClass)
    {
        $this->stdClass = $stdClass;
    }


    protected $name = 'mycommandwithdependency';

    protected $description = 'a mock command that has a dependency';

    public function handle($args)
    {
        return 'mycommandwithdependency handled';
    }
}
