<?php

namespace Telegram\Bot\Answers;

use BadMethodCallException;
use Illuminate\Contracts\Container\Container;
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
            return $this->$method(...$parameters);
        }

        throw new BadMethodCallException(sprintf('Method [%s] does not exist.', $method));
    }

    /**
     * Use PHP Reflection and Laravel Container to instantiate the answer with type hinted dependencies.
     */
    protected function buildDependencyInjectedClass(object|string $class): object
    {
        if (is_object($class)) {
            return $class;
        }

        if (! $this->telegram->hasContainer()) {
            return new $class;
        }

        $container = $this->telegram->getContainer();

        if ($container instanceof Container) {
            return $container->make($class);
        }

        return $container->get($class);
    }
}
