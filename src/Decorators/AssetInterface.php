<?php

namespace VS\Response\Decorators;

/**
 * Interface AssetInterface
 * @package VS\Response\Decorators
 */
interface AssetInterface
{
    /**
     * @param string $beforeAlias
     * @param string $url
     * @param string $alias
     * @return mixed
     */
    public function before(string $beforeAlias, string $url, string $alias);

    /**
     * @param string $beforeAlias
     * @param string $url
     * @param string $alias
     * @return mixed
     */
    public function after(string $beforeAlias, string $url, string $alias);

    /**
     * @param string $url
     * @param string $alias
     * @return AssetInterface
     */
    public function append(string $url, string $alias);

    /**
     * @param array $UrlAliasPairs
     * @return AssetInterface
     */
    public function appendBulk(array $UrlAliasPairs);

    /**
     * @param string $url
     * @param string $alias
     * @return AssetInterface
     */
    public function prepend(string $url, string $alias);

    /**
     * @param string $alias
     * @return mixed
     */
    public function remove(string $alias);

    /**
     * @param string $alias
     * @return mixed
     */
    public function getByAlias(string $alias);

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param string $extension
     * @return mixed
     */
    public function setExtension(string $extension);
}