<?php

use Telegram\Bot\Api;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Update;

uses(\Prophecy\PhpUnit\ProphecyTrait::class);
beforeEach(function () {
    $this->api = $this->prophesize(Api::class)->reveal();

    $this->command = $this->getMockForAbstractClass(Command::class)
        ->setName('demo');
});

test('a command with no pattern set will return an empty argument array', function () {
    //Condensed update data
    $update = new Update([
        'message' => [
            'text' => 'This /demo',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 5,
                    'length' => 5,
                ],
            ],
        ],
    ]);

    $entity = $update->getMessage()->entities->get(0)->toArray();
    $this->command->setPattern('');

    $this->command->make($this->api, $update, $entity);

    expect($this->command->getArguments())->toEqual([]);
});

test('a command with no pattern set but has text after the command will return an empty argument array', function () {
    //Condensed update data
    $update = new Update([
        'message' => [
            'text' => '/demo@testing_Bot John Doe',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 17,
                ],
            ],
        ],
    ]);
    $this->command->setPattern('');
    $entity = $update->getMessage()->entities->get(0)->toArray();
    $this->command->setPattern('');

    $this->command->make($this->api, $update, $entity);

    expect($this->command->getArguments())->toEqual([]);
});

test('a command with only required pattern variables is parsed correctly', function () {
    //Condensed update data
    $update = new Update([
        'message' => [
            'text' => '/demo@testing_Bot John Doe 77 200',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 17,
                ],
            ],
        ],
    ]);
    $entity = $update->getMessage()->entities->get(0)->toArray();
    $this->command->setPattern('{fname} {lname} {age} {weight}');

    $this->command->make($this->api, $update, $entity);

    expect($this->command->getArguments())->toEqual(['fname' => 'John', 'lname' => 'Doe', 'age' => '77', 'weight' => '200']);
});

test('a command with required and optional pattern variables is parsed correctly', function () {
    //Condensed update data
    $update = new Update([
        'message' => [
            'text' => '/demo@testing_Bot John Doe 77 200',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 17,
                ],
            ],
        ],
    ]);
    $entity = $update->getMessage()->entities->get(0)->toArray();
    $this->command->setPattern('{fname} {lname} {age?} {weight?}');

    $this->command->make($this->api, $update, $entity);

    expect($this->command->getArguments())->toEqual(['fname' => 'John', 'lname' => 'Doe', 'age' => '77', 'weight' => '200']);
});

test('a command with more required pattern variables than exists in update message is not matched', function () {
    //Condensed update data
    $update = new Update([
        'message' => [
            'text' => '/demo@testing_Bot John Doe 77',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 17,
                ],
            ],
        ],
    ]);
    $entity = $update->getMessage()->entities->get(0)->toArray();
    $this->command->setPattern('{fname} {lname} {age} {weight}');

    $this->command->make($this->api, $update, $entity);

    expect($this->command->getArguments())->toEqual([]);
});

test('a command with custom regex set as pattern will return an array with the match value', function () {
    //Condensed update data
    $update = new Update([
        'message' => [
            'text' => '/demo@testing_Bot eidw einn egaa egcc',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 17,
                ],
            ],
        ],
    ]);
    $entity = $update->getMessage()->entities->get(0)->toArray();
    $this->command->setPattern('.+');

    $this->command->make($this->api, $update, $entity);

    expect($this->command->getArguments())->toEqual(['custom' => 'eidw einn egaa egcc']);
});

test('a command with more advance custom regex set as pattern will return an array with the match value', function () {
    //Condensed update data
    $update = new Update([
        'message' => [
            'text' => '/demo@testing_Bot ei105 22/03/2017',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 0,
                    'length' => 17,
                ],
            ],
        ],
    ]);
    $entity = $update->getMessage()->entities->get(0)->toArray();
    $this->command->setPattern('[a-z]{2}\d{3}\s+?\d{2}/\d{2}/\d{2,4}');

    $this->command->make($this->api, $update, $entity);

    expect($this->command->getArguments())->toEqual(['custom' => 'ei105 22/03/2017']);
});

it('checks the arguments can be detected in a message with multiple commands that are the same', function () {
    //Condensed update data
    $update = new Update([
        'message' => [
            'text' => 'This /demo john doe command with /demo jane doe and a unrelated /test command',
            'entities' => [
                [
                    'type' => 'bot_command',
                    'offset' => 5,
                    'length' => 5,
                ],
                [
                    'type' => 'bot_command',
                    'offset' => 33,
                    'length' => 5,
                ],
                [
                    'type' => 'bot_command',
                    'offset' => 64,
                    'length' => 5,
                ],
            ],
        ],
    ]);

    $this->command->setPattern('{fname} {lname}');

    //First time the command is triggered for entity "0"
    $entity0 = $update->getMessage()->entities->get(0)->toArray();
    $this->command->make($this->api, $update, $entity0);
    expect($this->command->getArguments())->toEqual(['fname' => 'john', 'lname' => 'doe']);

    //Second time the command is triggered for entity "1"
    $entity1 = $update->getMessage()->entities->get(1)->toArray();
    $this->command->make($this->api, $update, $entity1);
    expect($this->command->getArguments())->toEqual(['fname' => 'jane', 'lname' => 'doe']);

    //This command should not be triggered for entity "2". But if it is, the arguments should be blank.
    $entity2 = $update->getMessage()->entities->get(2)->toArray();
    $this->command->make($this->api, $update, $entity2);
    expect($this->command->getArguments())->toEqual([]);
});
