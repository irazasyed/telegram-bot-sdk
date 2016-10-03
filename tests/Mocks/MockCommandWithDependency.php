<?php

namespace Telegram\Bot\Tests\Mocks;

use Telegram\Bot\Commands\Command;

/**
 * Class MockCommandWithDependency
 */
class MockCommandWithDependency extends Command
{

    /**
     * @var \stdClass
     */
    protected $stdClass;

    /**
     * MockCommandWithDependency constructor.
     *
     * @param \stdClass $stdClass
     */
    public function __construct(\stdClass $stdClass)
    {
        $this->stdClass = $stdClass;
    }


    protected $name = 'mycommandwithdependency';

    protected $description = 'a mock command that has a dependency';

    /**
     * @param $args
     *
     * @return string
     */
    public function handle($args)
    {
        return 'mycommandwithdependency handled';
    }
}
