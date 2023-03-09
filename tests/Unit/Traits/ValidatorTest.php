<?php

uses(\Telegram\Bot\Traits\Validator::class);
it('checks it can detect a file id', function () {
    $result01 = $this->isFileId('https://short.url');
    $result02 = $this->isFileId('/path/to/file.pdf');
    $result03 = $this->isFileId([]);
    $result04 = $this->isFileId('asuperlongfilenamethatisover20characters.pdf');

    $result10 = $this->isFileId('AwADBAADYwADO1wlBuF1ogMa7HnMAg');

    expect($result01)->toBeFalse();
    expect($result02)->toBeFalse();
    expect($result03)->toBeFalse();
    expect($result04)->toBeFalse();

    expect($result10)->toBeTrue();
});
