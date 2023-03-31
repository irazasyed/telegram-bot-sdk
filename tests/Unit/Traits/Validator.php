<?php

use Telegram\Bot\Traits\Validator;

uses(Validator::class);

it('checks it can detect a file id', function () {
    $result01 = $this->isFileId('https://short.url');
    $result02 = $this->isFileId('/path/to/file.pdf');
    $result03 = $this->isFileId('asuperlongfilenamethatisover20characters.pdf');
    $result04 = $this->isFileId('AwADBAADYwADO1wlBuF1ogMa7HnMAg');
    $result05 = $this->isFileId([]);

    expect($result01)->toBeFalse()
        ->and($result02)->toBeFalse()
        ->and($result03)->toBeFalse()
        ->and($result04)->toBeTrue()
        ->and($result05)->toBeFalse();
});
