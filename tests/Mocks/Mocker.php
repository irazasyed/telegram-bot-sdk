<?php

namespace Telegram\Bot\Tests\Mocks;

use Telegram\Bot\Api;
use Prophecy\Prophet;
use Prophecy\Argument;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Telegram\Bot\Objects\Update;
use GuzzleHttp\Handler\MockHandler;
use Telegram\Bot\HttpClients\GuzzleHttpClient;

class Mocker
{
    /**
     * Create a mocked API object with a container.
     *
     * @param bool $withContainer Should the mocked object have a mocked
     *                            container added to it?
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    public static function createApi($withContainer = false)
    {
        if ($withContainer) {
            $container = Mocker::createContainer();
            $container->make(Argument::any())->willReturn(new \stdClass());
        } else {
            $container = null;
        }

        $api = (new Prophet())->prophesize(Api::class);
        $api->hasContainer()->willReturn($withContainer);
        $api->getContainer()->willReturn($container);

        return $api;
    }

    /**
     * Create an IOC container that can be added to the API
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    public static function createContainer()
    {
        return (new Prophet())->prophesize(\Illuminate\Contracts\Container\Container::class);
    }

    /**
     * Create a mocked Update Object
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    public static function createUpdateObject()
    {
        return (new Prophet())->prophesize(Update::class);
    }

    /**
     * Creates a stub command that responds to getName() and make() method calls.
     *
     * @param string $name
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    public static function createMockCommand($name = 'start')
    {
        $command = (new Prophet())->prophesize(MockCommand::class);
        $command->getAliases()->willReturn(null);
        $command->getName()->willReturn($name);
        $command->make(Argument::any(), Argument::any(), Argument::any())->willReturn(null);

        return $command;
    }

    /**
     * This creates a full Update Response object with all the current fields set to blank.
     * Every field may be overwritten/customised with $messageParams array.
     *
     * @param array  $updateFields
     * @param string $updateId
     *
     * @return Api
     */
    public static function createUpdateResponse(array $updateFields = [], $updateId = '1')
    {
        $defaultResponseFields = [
            'message_id' => '',
            'from'       => [
                'id'         => '',
                'first_name' => '',
                'last_name'  => '',
                'username'   => '',
            ],
            'date'       => '',
            'chat'       => [
                'id'         => '',
                'type'       => '',
                'title'      => '',
                'username'   => '',
                'first_name' => '',
                'last_name'  => '',
            ],
        ];

        $response = [
            'result' => [
                [
                    'update_id' => $updateId,
                    'message'   => array_merge($defaultResponseFields, $updateFields),
                ],
            ],
        ];

        return self::setTelegramResponse($response);
    }

    /**
     * A shortcut to create an Update Response object with a message.
     * This makes writing tests that require a message Response a
     * little bit easier.
     *
     * @param $message
     *
     * @return Api
     */
    public static function createMessageResponse($message)
    {
        return self::createUpdateResponse(['text' => $message]);
    }


    /**
     * This creates a raw api response to simulate what Telegram replies
     * with.
     *
     * @param array $apiResponseFields
     * @param bool  $ok
     *
     * @return Api
     */
    public static function createApiResponse(array $apiResponseFields, $ok = true)
    {
        $response = [
            'ok'          => $ok,
            'description' => '',
            'result'      => $apiResponseFields,
        ];

        return self::setTelegramResponse($response);
    }

    /**
     * Recreates the Api object, using a mock http client, with predefined
     * responses containing the provided $body.
     *
     * @param $body
     *
     * @return Api
     */
    private static function setTelegramResponse($body)
    {
        $body = json_encode($body);
        $mock = new MockHandler([
            new Response(200, [], $body),
            new Response(200, [], $body),
            // two times because Api::commandsHandler makes two requests (when not using webhook method).
        ]);
        $handler = HandlerStack::create($mock);
        $client = new GuzzleHttpClient(new Client(['handler' => $handler]));

        return new Api('token', false, $client);
    }
}
