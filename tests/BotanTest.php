<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Helpers\Botan;

class BotanTest extends \PHPUnit_Framework_TestCase
{
    private $botan_token = '26c6df87-56ea-4764-a588-0e25de3a64a9';

    /**
     * @var Botan
     */
    protected $botan;

    /**
     * @test
     * @expectedException \Exception
     */
    public function it_throws_exception_when_no_token_is_provided()
    {
        $this->botan = new Botan('');
    }

    /** @test */
    public function it_created_with_non_empty_token()
    {
        $this->botan = new Botan($this->botan_token);
        $this->assertNotNull($this->botan);
    }

    /** @test */
    public function it_sends_event()
    {
        $data = array("from"=>array("id"=>1));
        $this->botan = new Botan($this->botan_token);
        $result = $this->botan->track($data, 'event');
   	$this->assertTrue($result); 
    }

    /** @test
     * @expectedException \Exception
     */
    public function it_fails_on_wrong_message()
    {
        $data = array("test"=>1);
        $this->botan = new Botan($this->botan_token);
        $result = $this->botan->track($data, 'event');
   	$this->assertTrue($result); 
    }

}
