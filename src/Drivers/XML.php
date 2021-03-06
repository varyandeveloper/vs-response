<?php

namespace VS\Response\Drivers;

use VS\Response\ResponseInterface;
use VS\General\STR;

/**
 * Class XML
 * @package VS\Response\Drivers
 * @author Varazdat Stepanyan
 */
class XML extends AbstractDriver
{
    /**
     * @var string
     */
    private static $chilNodeName;

    /**
     * XML constructor.
     * @param ResponseInterface $response
     * @param iterable $data
     * @param string $childNodeName
     * @param string $root
     * @param int $options
     * @throws \Exception
     */
    public function __construct(ResponseInterface $response, iterable $data, string $childNodeName = 'node', string $root = 'document', int $options = 0)
    {
        parent::__construct($response);
        static::$chilNodeName = $childNodeName;
        $root = ucfirst($root);
        $xmlElement = new \SimpleXMLElement("<?xml version=\"1.0\"?><" . $root . "></" . $root . ">", $options);
        self::iterableToXML($data, $xmlElement);
        $xmlContent = $xmlElement->asXML();
        if (!$xmlContent) {
            throw new \Exception('XML generation failed');
        }
        $this->setContent($xmlContent);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString(): string
    {
        if (!headers_sent()) {
            header('Content-Type: application/xml; charset=utf-8');
        }
        return parent::__toString();
    }

    /**
     * @param iterable $data
     * @param \SimpleXMLElement $element
     */
    protected static function iterableToXML(iterable $data, \SimpleXMLElement $element)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    self::iterableToXML($value, $element->addChild(STR::camel($key)));
                } else {
                    self::iterableToXML($value, $element->addChild(STR::camel(static::$chilNodeName)));
                }
            } else {
                $element->addChild(STR::camel($key), htmlspecialchars("$value"));
            }
        }
    }
}