<?php
declare(strict_types=1);

namespace Telegram\Bot\Tests;

use Telegram\Bot\Commands\CommandBus;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function mockCommandBus()
    {
        return $this->createMock(CommandBus::class);
    }
}