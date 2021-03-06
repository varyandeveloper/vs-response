<?php

namespace VS\Response;

use VS\General\Configurable\ConfigurableInterface;
use VS\Response\Drivers\{
    DriverInterface, Json, XML, View
};

/**
 * Interface ResponseInterface
 * @package VS\Response
 * @author Varazdat Stepanyan
 *
 * @method Json json(iterable $data, int $options = JSON_PRETTY_PRINT, int $depth = 512)
 * @method XML xml(iterable $data, string $root = 'document', int $options = 0)
 * @method View view(string $viewName, array $data = [])
 */
interface ResponseInterface extends ConfigurableInterface
{
    /**
     * @param string $class
     * @param array ...$args
     * @return DriverInterface
     */
    public function make(string $class, ...$args): DriverInterface;

    /**
     * @param string $name
     * @param array $arguments
     * @return DriverInterface
     */
    public function __call(string $name, array $arguments): DriverInterface;
}