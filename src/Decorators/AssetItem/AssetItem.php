<?php

namespace VS\Response\Decorators\AssetItem;

/**
 * Class AssetItem
 * @package VS\Response\Decorators\AssetItem
 */
class AssetItem implements AssetItemInterface
{
    /**
     * @var string $_url
     */
    protected $_url;
    /**
     * @var string $_alias
     */
    protected $_alias;

    /**
     * StyleItem constructor.
     * @param string $url
     * @param string $alias
     */
    public function __construct(string $url, string $alias)
    {
        $this->setUrl($url);
        $this->setAlias($alias);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->_url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->_url = $url;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->_alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias(string $alias)
    {
        $this->_alias = $alias;
    }
}