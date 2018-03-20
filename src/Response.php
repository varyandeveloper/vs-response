<?php

namespace VS\Response;

use VS\General\Configurable\ConfigurableTrait;
use VS\General\DIFactory;
use VS\Response\Drivers\DriverInterface;

/**
 * Class Response
 * @package VS\Response
 * @author Varazdat Stepanyan
 */
class Response implements ResponseInterface
{
    use ConfigurableTrait;

    /**
     * Response constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    /**
     * @param string $class
     * @param array ...$args
     * @return DriverInterface
     */
    public function make(string $class, ...$args): DriverInterface
    {
        if (!class_exists($class)) {
            if (ResponseConstants::isAllowedDriver($class)) {
                $class = ResponseConstants::getDriver($class);
            } else {
                throw new \InvalidArgumentException(sprintf(
                    'Undefined response driver %s.',
                    $class
                ));
            }
        }
        /**
         * @var DriverInterface $driverObject
         */
        $driverObject = DIFactory::injectClass($class, $this, ...$args);
        return $driverObject;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return DriverInterface
     */
    public function __call(string $name, array $arguments): DriverInterface
    {
        if (!ResponseConstants::isAllowedDriver($name)) {
            throw new \BadMethodCallException(sprintf(
                'Class %s dose not have %s method.',
                __CLASS__,
                $name
            ));
        }
        return $this->make($name, ...$arguments);
    }
}