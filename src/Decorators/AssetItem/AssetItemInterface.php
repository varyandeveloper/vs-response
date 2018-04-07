<?php

namespace VS\Response\Decorators\AssetItem;

/**
 * Interface AssetItemInterface
 * @package VS\Response\Decorators
 */
interface AssetItemInterface
{
    /**
     * AssetItemInterface constructor.
     * @param string $url
     * @param string $alias
     */
    public function __construct(string $url, string $alias);

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $url
     * @return mixed
     */
    public function setUrl(string $url);

    /**
     * @return string
     */
    public function getAlias(): string;

    /**
     * @param string $alias
     * @return mixed
     */
    public function setAlias(string $alias);
}