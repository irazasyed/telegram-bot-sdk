<?php

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Telegram\Bot\Api;
use Telegram\Bot\Tests\Traits\GuzzleMock;

uses(GuzzleMock::class);

function paymentsApi($client = null, $token = 'TELEGRAM_TOKEN'): Api
{
    return new Api($token, false, $client);
}

function invoiceLinkParams(): array
{
    return [
        'title' => 'Test Product',
        'description' => 'Test product description',
        'payload' => 'test_payload_123',
        'provider_token' => '',
        'currency' => 'XTR',
        'prices' => [
            ['label' => 'Product', 'amount' => 100],
        ],
    ];
}

function makeInvoiceLinkResponse(string $invoiceLink): Response
{
    return new Response(
        200,
        [],
        json_encode([
            'ok' => true,
            'result' => $invoiceLink,
        ])
    );
}

test('createInvoiceLink sends request to correct endpoint', function () {
    $fakeResponse = makeInvoiceLinkResponse('https://t.me/invoice/abc123');

    $api = paymentsApi($this->getGuzzleHttpClient([$fakeResponse]));
    $api->createInvoiceLink(invoiceLinkParams());

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();

    expect($request->getUri()->getPath())->toEqual('/botTELEGRAM_TOKEN/createInvoiceLink');
});

test('createInvoiceLink returns invoice link as string', function () {
    $invoiceLink = 'https://t.me/invoice/abc123';
    $fakeResponse = makeInvoiceLinkResponse($invoiceLink);

    $api = paymentsApi($this->getGuzzleHttpClient([$fakeResponse]));
    $result = $api->createInvoiceLink(invoiceLinkParams());

    expect($result)->toBeString()
        ->and($result)->toEqual($invoiceLink);
});

test('createInvoiceLink json encodes prices parameter', function () {
    $fakeResponse = makeInvoiceLinkResponse('https://t.me/invoice/abc123');

    $api = paymentsApi($this->getGuzzleHttpClient([$fakeResponse]));
    $api->createInvoiceLink(invoiceLinkParams());

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    $expectedPrices = json_encode([['label' => 'Product', 'amount' => 100]]);
    expect($body)->toContain('prices='.urlencode($expectedPrices));
});

test('createInvoiceLink sends all required parameters', function () {
    $fakeResponse = makeInvoiceLinkResponse('https://t.me/invoice/abc123');

    $api = paymentsApi($this->getGuzzleHttpClient([$fakeResponse]));
    $api->createInvoiceLink(invoiceLinkParams());

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($body)->toContain('title=Test+Product')
        ->and($body)->toContain('description=Test+product+description')
        ->and($body)->toContain('payload=test_payload_123')
        ->and($body)->toContain('currency=XTR');
});

test('createInvoiceLink sends optional parameters when provided', function () {
    $fakeResponse = makeInvoiceLinkResponse('https://t.me/invoice/abc123');

    $params = invoiceLinkParams();
    $params['photo_url'] = 'https://example.com/photo.jpg';
    $params['need_name'] = true;
    $params['need_email'] = true;

    $api = paymentsApi($this->getGuzzleHttpClient([$fakeResponse]));
    $api->createInvoiceLink($params);

    /** @var Request $request */
    $request = $this->getHistory()->pluck('request')->first();
    $body = (string) $request->getBody();

    expect($body)->toContain('photo_url='.urlencode('https://example.com/photo.jpg'))
        ->and($body)->toContain('need_name=1')
        ->and($body)->toContain('need_email=1');
});
