<?php

namespace Telegram\Bot\Answers;

use Telegram\Bot\Traits\Telegram;

/**
 * Class AnswerBus.
 */
abstract class AnswerBus
{
    use Telegram;

    /**
     * Handle calls to missing methods.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $parameters);
        }

        throw new \BadMethodCallException("Method [$method] does not exist.");
    }

    /**
     * Use PHP Reflection and Laravel Container to instantiate the answer with type hinted dependencies.
     *
     * @param $answerClass
     *
     * @return object
     */
    protected function buildDependencyInjectedAnswer($answerClass)
    {
        // check if the command has a constructor
        if (! method_exists($answerClass, '__construct')) {
            return new $answerClass();
        }

        // get constructor params
        $constructorReflector = new \ReflectionMethod($answerClass, '__construct');
        $params = $constructorReflector->getParameters();

        // if no params are needed proceed with normal instantiation
        if (empty($params)) {
            return new $answerClass();
        }

        // otherwise fetch each dependency out of the container
        $container = $this->telegram->getContainer();
        $dependencies = [];
        foreach ($params as $param) {
            if (version_compare(PHP_VERSION, '8.0.0') >= 0) {
                $dependencies[] = $container->make($param->getType()->getName());
            }
            else{
                $dependencies[] = $container->make($param->getClass()->name);
            }
        }

        // and instantiate the object with dependencies through ReflectionClass
        $classReflector = new \ReflectionClass($answerClass);

        return $classReflector->newInstanceArgs($dependencies);
    }
}
