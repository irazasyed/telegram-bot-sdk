<?php

namespace Telegram\Bot\Methods;

/**
 * Class Method
 */
abstract class Method
{
    /** @var array Holds method params */
    protected $payload = [];

    /** @var Factory Holds methods Factory instance */
    protected $factory;

    /** @var string|null Field name in params that should be InputFile instance */
    protected $fileUploadField = null;

    /** @var bool Method has no params */
    protected $noParams = false;

    /** @var bool Make GET request for this method. Defaults to POST. */
    protected $getRequest = false;

    /**
     * Make method.
     *
     * @param array $payload
     *
     * @return static
     */
    public static function make(array $payload = [])
    {
        return new static($payload);
    }

    /**
     * Method constructor.
     *
     * @param array $payload
     */
    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    /**
     * Returns payload array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->payload;
    }

    /**
     * Dump payload and die :D
     * Easy Debugging!
     */
    public function dd()
    {
        dd($this->payload);
    }

    /**
     * Set Factory Instance.
     *
     * @param Factory $factory
     */
    protected function setFactory(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Returns API Endpoint for this method.
     *
     * @return string
     */
    protected function apiEndpoint()
    {
        return camel_case(class_basename($this));
    }

    /**
     * Field name in params that should be InputFile instance.
     *
     * @return null|string
     */
    protected function fileUploadField()
    {
        return $this->fileUploadField;
    }

    /**
     * Determine if this method has no params.
     *
     * @return bool
     */
    protected function hasNoParams()
    {
        return $this->noParams;
    }

    /**
     * Determine if it should be a GET request for this method.
     *
     * @return bool
     */
    protected function isGetRequest()
    {
        return $this->getRequest;
    }

    /**
     * Invoked before any API requests.
     * Useful to hook validations and other stuffs.
     */
    protected function beforeCallHook()
    {
    }

    /**
     * Set return type for this method.
     * It can be an object class name.
     *
     * @return mixed
     */
    abstract protected function returns();

    /**
     * Magic method to set properties dynamically or get methods.
     *
     * @param $name
     * @param $arguments
     *
     * @return $this|mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        if (in_array($name, ['getResult', 'go'])) {
            return $this->factory->getResult($arguments);
        }

        $this->payload[snake_case($name)] = $arguments[0];

        return $this;
    }
}