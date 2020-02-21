<?php

namespace Telegram\Bot\Tests\Unit\Methods;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Methods\Update;

class UpdateTest extends TestCase
{
    use Update;

    /**
     * @test
     */
    public function a_webhook_url_must_use_secure_http()
    {
        $this->expectException(TelegramSDKException::class);
        $this->setWebhook([
            'url' => 'http://example.com',
        ]);
    }

    /**
     * @test
     */
    public function a_webhook_must_have_a_valid_url()
    {
        $this->expectException(TelegramSDKException::class);
        $this->setWebhook([
            'url' => 'not a valid url',
        ]);
    }
}
