<?php

namespace VS\Response;

use VS\Response\Drivers\{
    Json, View, XML
};

/**
 * Class ResponseConstants
 * @package VS\Response
 * @author Varazdat Stepanyan
 */
class ResponseConstants
{
    const DRIVER_JSON_ALIAS = 'json';
    const DRIVER_XML_ALIAS = 'xml';
    const DRIVER_VIEW_ALIAS = 'view';

    const DRIVER_JSON_CLASS = Json::class;
    const DRIVER_XML_CLASS = XML::class;
    const DRIVER_VIEW_CLASS = View::class;

    protected const DRIVERS = [
        self::DRIVER_JSON_ALIAS => self::DRIVER_JSON_CLASS,
        self::DRIVER_XML_ALIAS => self::DRIVER_XML_CLASS,
        self::DRIVER_VIEW_ALIAS => self::DRIVER_VIEW_CLASS,
    ];

    /**
     * @var array $drivers
     */
    protected static $drivers = [];

    /**
     * @param string $alias
     * @return bool|mixed
     */
    public static function getDriver(string $alias)
    {
        $driver = self::$drivers[$alias] ?? self::DRIVERS[$alias] ?? false;
        if (!$driver) {
            throw new \InvalidArgumentException(sprintf(
                'There is no driver registered under alias %S in %s',
                $alias,
                __CLASS__
            ));
        }

        return $driver;
    }

    /**
     * @param string $alias
     * @return bool
     */
    public static function isAllowedDriver(string $alias): bool
    {
        $driver = self::$drivers[$alias] ?? self::DRIVERS[$alias] ?? false;
        return false !== $driver;
    }

    /**
     * @param array $drivers
     */
    public static function setDrivers(array $drivers): void
    {
        self::$drivers = $drivers;
    }
}