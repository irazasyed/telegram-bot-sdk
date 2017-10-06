<?php

namespace Telegram\Bot\Tests\Unit\Methods;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Methods\Update;

class UpdateTest extends TestCase
{
    use Update;

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function a_webhook_url_must_use_secure_http()
    {
        $this->setWebhook([
            'url' => 'http://example.com',
        ]);
    }

    /**
     * @test
     * @expectedException \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function a_webhook_must_have_a_valid_url()
    {
        $this->setWebhook([
            'url' => 'not a valid url',
        ]);
    }
}
