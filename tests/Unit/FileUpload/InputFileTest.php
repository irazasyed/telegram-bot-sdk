<?php

use GuzzleHttp\Psr7\LazyOpenStream;
use Telegram\Bot\FileUpload\InputFile;

beforeEach(function () {
    $this->tempPath = sys_get_temp_dir();
    $this->tempFileName = $this->tempPath.'/TestFile.tmp';
    $this->tempFileResource = fopen($this->tempFileName, 'w+');
    $this->tempStream = new LazyOpenStream($this->tempFileName, 'r');
});

afterEach(function () {
    if (file_exists($this->tempFileName)) {
        unlink($this->tempFileName);
    }
});

it('detects the file name from a stream or resource or url or string', function () {
    $inputFileString = InputFile::create($this->tempFileName);
    $inputFileUrlWithExtension = InputFile::create('http://localhost/remoteFile.tmp');
    $inputFileUrlNoExtension = InputFile::create('http://localhost/uo13nzxcl5014pnSX7DIty16k_H47F_GulRO');
    $inputFileResource = InputFile::create($this->tempFileResource);
    $inputFileStream = InputFile::create($this->tempStream);

    expect($inputFileString->getFilename())->toEqual('TestFile.tmp');
    expect($inputFileUrlWithExtension->getFilename())->toEqual('remoteFile.tmp');
    expect($inputFileUrlNoExtension->getFilename())->toEqual('uo13nzxcl5014pnSX7DIty16k_H47F_GulRO');
    expect($inputFileResource->getFilename())->toEqual('TestFile.tmp');
    expect($inputFileStream->getFilename())->toEqual('TestFile.tmp');
});

it('overrides the original filename if another filename is provided', function () {
    $inputFileString = InputFile::create($this->tempFileName, 'newFileNameString.jpg');
    $inputFileResource = InputFile::create($this->tempFileResource, 'newFileNameResource.jpg');
    $inputFileStream = InputFile::create($this->tempStream, 'newFileNameStream.jpg');

    expect($inputFileString->getFilename())->toEqual('newFileNameString.jpg');
    expect($inputFileResource->getFilename())->toEqual('newFileNameResource.jpg');
    expect($inputFileStream->getFilename())->toEqual('newFileNameStream.jpg');
});

it('ensures the open method return resource', function () {
    $object = new InputFile('https://telegram.org/img/t_logo.png');

    try {
        expect(true)->toEqual(is_resource($object->getContents()));
    } catch (RuntimeException $runtimeException

    ) {
        /*
         * skip this test, if run without internet connection
         */
        expect($object)->toBeInstanceOf(InputFile::class);
    }
});
