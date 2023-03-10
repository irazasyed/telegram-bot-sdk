<?php

namespace Telegram\Bot\Answers;

use BadMethodCallException;
use ReflectionClass;
use ReflectionMethod;
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
     * @return mixed
     *
     * @throws BadMethodCallException
     */
    public function __call(string $method, array $parameters)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $parameters);
        }

        throw new BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
    }

    /**
     * Use PHP Reflection and Laravel Container to instantiate the answer with type hinted dependencies.
     */
    protected function buildDependencyInjectedAnswer($answerClass): object
    {
        // check if the command has a constructor
        if (! method_exists($answerClass, '__construct')) {
            return new $answerClass();
        }

        // get constructor params
        $constructorReflector = new ReflectionMethod($answerClass, '__construct');
        $params = $constructorReflector->getParameters();

        // if no params are needed proceed with normal instantiation
        if ($params === []) {
            return new $answerClass();
        }

        // otherwise fetch each dependency out of the container
        $container = $this->telegram->getContainer();
        $dependencies = [];
        foreach ($params as $param) {
            $dependencies[] = $container->make($param->getType()->getName());
        }

        // and instantiate the object with dependencies through ReflectionClass
        return (new ReflectionClass($answerClass))->newInstanceArgs($dependencies);
    }
}
