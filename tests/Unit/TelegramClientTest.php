<?php

declare(strict_types=1);

namespace Telegram\Bot\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\TelegramClient;
use Telegram\Bot\TelegramRequest;

class TelegramClientTest extends TestCase
{
    /** @test */
    public function it_test_custom_base_bot_url(): void
    {
        $customBaseUrl = 'http://custom.com/';
        $client = new TelegramClient(null, $customBaseUrl);

        $this->assertEquals($customBaseUrl, $client->getBaseBotUrl());

        $accessToken = 'token';
        $method = 'POST';
        $endpoint = 'endpoint';
        $params = ['param' => 'value'];
        [$url] = $client->prepareRequest(
            new TelegramRequest($accessToken, $method, $endpoint, $params)
        );

        $this->assertEquals($customBaseUrl . $accessToken . '/' . $endpoint, $url);
    }
}
