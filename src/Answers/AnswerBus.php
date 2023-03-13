<?php

namespace Telegram\Bot\Answers;

use BadMethodCallException;
use ReflectionClass;
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
    protected function buildDependencyInjectedClass(object|string $class): object
    {
        $classReflector = new ReflectionClass($class);
        $constructorReflector = $classReflector->getConstructor();

        if (! $constructorReflector) {
            return new $class();
        }

        // get constructor params
        $params = $constructorReflector->getParameters();

        // if no params are needed proceed with normal instantiation
        if ($params === []) {
            return new $class();
        }

        // otherwise fetch each dependency out of the container
        $container = $this->telegram->getContainer();
        $dependencies = array_map(static fn ($param) => $container->make($param->getType()?->getName()), $params);

        // and instantiate the object with dependencies through ReflectionClass
        return $classReflector->newInstanceArgs($dependencies);
    }
}
