<?php

namespace VS\Response\Drivers;

/**
 * Interface DriverInterface
 * @package VS\Response\Drivers
 * @author Varazdat Stepanyan
 */
interface DriverInterface
{
    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     * @return DriverInterface
     */
    public function setStatus(int $status): DriverInterface;

    /**
     * @return string
     */
    public function __toString(): string;
}