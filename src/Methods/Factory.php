<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\UnknownObject;
use Telegram\Bot\TelegramResponse;
use Telegram\Bot\Traits\Telegram;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class Factory
 */
class Factory
{
    use Telegram;

    /** @var mixed Holds Result with Return Type */
    protected $result;

    /** @var Method Holds method object instance */
    protected $method;

    /** @var TelegramResponse Holds Telegram API Response */
    protected $response;

    /**
     * Factory constructor.
     *
     * @param Api $telegram
     */
    public function __construct(Api $telegram)
    {
        $this->setTelegram($telegram);
    }

    /**
     * @param       $method
     * @param array $params
     *
     * @return Factory
     * @throws TelegramSDKException
     */
    public function create($method, $params = [])
    {
        $class = 'Telegram\Bot\Methods\\'.studly_case($method);

        if (!class_exists($class)) {
            $response = $this->getTelegram()->post($method, $params);

            return new UnknownObject($response->getDecodedBody());
        }

        $this->method = new $class($params);
        $this->method->setFactory($this);

        if (empty($this->method->toArray()) && !$this->method->hasNoParams()) {
            return $this->method;
        }

        return $this->getResult();
    }

    /**
     * Make an api call and return result.
     *
     * @param bool $dumpAndDie
     *
     * @return mixed
     */
    public function getResult($dumpAndDie = false)
    {
        if ($dumpAndDie) {
            dd($this->call());
        }

        return $this->call();
    }

    /**
     * Alias for getResult() method.
     *
     * @param bool $dumpAndDie
     *
     * @return mixed
     */
    public function go($dumpAndDie = false)
    {
        return $this->getResult($dumpAndDie);
    }

    /**
     * Make an API Request.
     *
     * @return mixed
     */
    protected function call()
    {
        if ($this->result) {
            return $this->result;
        }

        /** Invoke before call hook */
        $this->method->beforeCallHook();

        if ($this->method->fileUploadField()) {
            $response = $this->uploadFile();
        } else {
            $response = $this->apiRequest();
        }

        /** @var TelegramResponse */
        $this->response = $response;

        $returns = $this->method->returns();

        if (is_string($returns) && class_exists($returns)) {
            return $this->result = new $returns($this->response->getDecodedBody());
        }

        return $this->result = $returns;
    }

    /**
     * @return TelegramResponse
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Make an API request.
     *
     * @return \Telegram\Bot\TelegramResponse
     */
    protected function apiRequest()
    {
        $request = 'post';
        if ($this->method->isGetRequest()) {
            $request = 'get';
        }

        return $this->getTelegram()->{$request}($this->method->apiEndpoint(), $this->method->toArray());
    }

    /**
     * Make Upload File Request.
     *
     * @return \Telegram\Bot\TelegramResponse
     */
    protected function uploadFile()
    {
        return $this->getTelegram()->uploadFile(
            $this->method->apiEndpoint(),
            $this->method->toArray(),
            $this->method->fileUploadField()
        );
    }
}