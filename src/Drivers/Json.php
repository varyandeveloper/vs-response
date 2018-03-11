<?php

namespace VS\Response\Drivers;
use VS\Response\ResponseInterface;

/**
 * Class Json
 * @package VS\Response\Drivers
 * @author Varazdat Stepanyan
 */
class Json extends AbstractDriver
{
    /**
     * Json constructor.
     * @param ResponseInterface $response
     * @param iterable $data
     * @param int $options
     * @param int $depth
     */
    public function __construct(ResponseInterface $response, iterable $data, int $options = JSON_PRETTY_PRINT, int $depth = 512)
    {
        parent::__construct($response);
        $this->setContent(json_encode($data, $options, $depth));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString(): string
    {
        header('Content-Type: application/json; charset=utf-8');
        return parent::__toString();
    }
}