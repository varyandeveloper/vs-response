<?php

namespace VS\Response\Drivers;

use VS\General\Configurable\{
    ConfigurableInterface, ConfigurableTrait
};
use VS\Response\ResponseInterface;

/**
 * Class AbstractDriver
 * @package VS\Response\Drivers
 * @author Varazdat Stepanyan
 */
abstract class AbstractDriver implements DriverInterface, ConfigurableInterface
{
    use ConfigurableTrait;

    /**
     * @var string $_content
     */
    protected $content;
    /**
     * @var int $_status
     */
    protected $status = 200;
    /**
     * @var ResponseInterface $Response
     */
    protected $Response;

    /**
     * AbstractDriver constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->Response = $response;
        $this->setConfig($this->Response->getConfig());
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return DriverInterface
     */
    public function setStatus(int $status): DriverInterface
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString(): string
    {
        if (!headers_sent() && $this->has('headers')) {
            $headers = $this->getConfig('headers');
            if (is_array($headers)) {
                foreach ($headers as $type => $value) {
                    header(sprintf('%s: %s', $type, $value));
                }
            }
        }
        http_response_code($this->getStatus());
        return $this->getContent();
    }

    /**
     * @param string $content
     * @return string
     */
    protected function setContent(string $content)
    {
        $this->content = $content;
    }
}