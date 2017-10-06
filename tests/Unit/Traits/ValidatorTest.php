<?php

namespace Telegram\Bot\Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Traits\Validator;

class ValidatorTest extends TestCase
{
    use Validator;

    /** @test */
    public function it_checks_it_can_detect_a_file_id()
    {
        $result01 = $this->isFileId('https://short.url');
        $result02 = $this->isFileId('/path/to/file.pdf');
        $result03 = $this->isFileId([]);
        $result04 = $this->isFileId('asuperlongfilenamethatisover20characters.pdf');

        $result10 = $this->isFileId('AwADBAADYwADO1wlBuF1ogMa7HnMAg');

        $this->assertFalse($result01);
        $this->assertFalse($result02);
        $this->assertFalse($result03);
        $this->assertFalse($result04);

        $this->assertTrue($result10);
    }
}
