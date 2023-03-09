<?php

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

function streamFor($resource): Psr\Http\Message\StreamInterface
{
    if (class_exists(\GuzzleHttp\Psr7\Utils::class)) {
        return \GuzzleHttp\Psr7\Utils::streamFor($resource);
    }

    throw new RuntimeException('Not found "streamFor" implementation');
}
