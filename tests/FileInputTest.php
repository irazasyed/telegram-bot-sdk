<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\FileUpload\InputFile;

class FileInputTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_ensures_the_open_method_return_resource()
    {
        $object = new InputFile('https://telegram.org/img/t_logo.png');

        $this->assertEquals(is_resource($object->open()), true);
    }

    /** @test */
    public function it_ensures_the_getFileName_use_basename()
    {
        $object = new InputFile('https://telegram.org/img/t_logo.png');

        $this->assertEquals($object->getFileName(), basename('https://telegram.org/img/t_logo.png'));
    }
}
