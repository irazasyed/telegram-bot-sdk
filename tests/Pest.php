<?php

use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamInterface;

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function streamFor($resource): StreamInterface
{
    if (class_exists(Utils::class)) {
        return Utils::streamFor($resource);
    }

    throw new RuntimeException('Not found "streamFor" implementation');
}
