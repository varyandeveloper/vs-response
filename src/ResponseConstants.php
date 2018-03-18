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
    const OK_CODE = 200;
    const CREATED_CODE = 201;
    const ACCEPTED_CODE = 202;
    const NON_AUTHORITATIVE_INFORMATION_CODE = 203;
    const NO_CONTENT_CODE = 204;
    const RESET_CONTENT_CODE = 205;
    const NOT_MODIFIED_CODE = 304;
    const BAD_REQUEST_CODE = 400;
    const UNAUTHORIZED_CODE = 401;
    const FORBIDDEN_CODE = 403;
    const NOT_FOUND_CODE = 404;
    const CONFLICT_CODE = 409;
    const INTERNAL_SERVER_ERROR_CODE = 500;

    const CREATED_MESSAGE = 'Request has ben saved successfully';
    const ACCEPTED_MESSAGE = 'Request has ben accepted successfully';
    const NON_AUTHORITATIVE_INFORMATION_MESSAGE = 'Missing authoritative information';
    const NO_CONTENT_MESSAGE = 'Missing content';
    const RESET_CONTENT_MESSAGE = 'Content reset';
    const INTERNAL_SERVER_ERROR_MESSAGE = 'Internal server error';
    const BAD_REQUEST_MESSAGE = 'The request could not be understood by the server due to malformed syntax';
    const FORBIDDEN_MESSAGE = 'The server understood the request, but is refusing to fulfill it';
    const NOT_FOUND_MESSAGE = 'The server has not found anything matching the Request-URI';
    const UNAUTHORIZED_MESSAGE = 'The request requires user authentication';

    const DRIVER_JSON_ALIAS = 'json';
    const DRIVER_XML_ALIAS = 'xml';
    const DRIVER_VIEW_ALIAS = 'view';

    const DRIVER_JSON_CLASS = Json::class;
    const DRIVER_XML_CLASS = XML::class;
    const DRIVER_VIEW_CLASS = View::class;

    protected const DEFAULT_LANG = 'en';

    protected const MESSAGES = [
        self::DEFAULT_LANG => [
            self::CREATED_CODE => self::CREATED_MESSAGE,
            self::ACCEPTED_CODE => self::ACCEPTED_MESSAGE,
            self::NON_AUTHORITATIVE_INFORMATION_CODE => self::NON_AUTHORITATIVE_INFORMATION_MESSAGE,
            self::NO_CONTENT_CODE => self::NO_CONTENT_MESSAGE,
            self::RESET_CONTENT_CODE => self::RESET_CONTENT_MESSAGE,
            self::INTERNAL_SERVER_ERROR_CODE => self::INTERNAL_SERVER_ERROR_MESSAGE,
            self::FORBIDDEN_CODE => self::FORBIDDEN_MESSAGE,
            self::UNAUTHORIZED_CODE => self::UNAUTHORIZED_MESSAGE,
            self::BAD_REQUEST_CODE => self::BAD_REQUEST_MESSAGE,
            self::NOT_FOUND_CODE => self::NOT_FOUND_MESSAGE
        ],
    ];

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
     * @var array $messages
     */
    protected static $messages = [];

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

    /**
     * @param array $messages
     */
    public static function setMessages(array $messages): void
    {
        self::$messages = $messages;
    }

    /**
     * @param int $code
     * @param string $lang
     * @return string
     */
    public static function getMessage(int $code, string $lang = self::DEFAULT_LANG): string
    {
        $message = self::$messages[$lang][$code] ?? self::MESSAGES[$lang] ?? false;

        if (false === $message) {
            throw new \InvalidArgumentException(sprintf(
                'There is no message registered under code %d in %s',
                $code,
                __METHOD__
            ));
        }

        return $message;
    }
}