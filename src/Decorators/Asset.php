<?php

namespace VS\Response\Decorators;

use VS\Response\Decorators\AssetItem\AssetItem;

/**
 * Class Asset
 * @package VS\Response\Decorators
 */
class Asset implements AssetInterface
{
    /**
     * @var AssetItemInterface[] $assets
     */
    private $assets = [];
    /**
     * @var string $extension
     */
    private $extension;

    /**
     * Asset constructor.
     * @param string|null $extension
     */
    public function __construct(string $extension = null)
    {
        $this->extension = $extension;
    }

    /**
     * @param string $beforeAlias
     * @param string $url
     * @param string $alias
     * @return $this
     */
    public function before(string $beforeAlias, string $url, string $alias)
    {
        $ordered = [];
        foreach ($this->assets as $asset) {
            if($asset->getAlias() === $beforeAlias) {
                $ordered[] = $this->buildItem($this->buildUrl($url), $alias);
            }
            $ordered[] = $asset;
        }
        $this->assets = $ordered;
        return $this;
    }

    /**
     * @param string $beforeAlias
     * @param string $url
     * @param string $alias
     * @return $this
     */
    public function after(string $beforeAlias, string $url, string $alias)
    {
        $ordered = [];
        foreach ($this->assets as $asset) {
            $ordered[] = $asset;
            if($asset->getAlias() === $beforeAlias) {
                $ordered[] = $this->buildItem($this->buildUrl($url), $alias);
            }
        }
        $this->assets = $ordered;
        return $this;
    }

    /**
     * @param string $url
     * @param string $alias
     * @return $this
     */
    public function append(string $url, string $alias): Asset
    {
        $this->assets[] = $this->buildItem($this->buildUrl($url), $alias);
        return $this;
    }

    /**
     * @param array $UrlAliasPairs
     * @return $this
     */
    public function appendBulk(array $UrlAliasPairs): Asset
    {
        foreach ($UrlAliasPairs as $url => $alias) {
            $this->append($url, $alias);
        }
        return $this;
    }

    /**
     * @param string $url
     * @param string $alias
     * @return $this
     */
    public function prepend(string $url, string $alias): Asset
    {
        array_unshift($this->assets, $this->buildItem($this->buildUrl($url), $alias));
        return $this;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function remove(string $alias): Asset
    {
        foreach ($this->assets as $index => $asset) {
            if ($asset->getAlias() === $alias) {
                unset($this->assets[$index]);
                break;
            }
        }

        return $this;
    }

    /**
     * @param string $alias
     * @return null
     */
    public function getByAlias(string $alias)
    {
        foreach ($this->assets as $asset) {
            if ($asset->getAlias() === $alias) {
                return $asset[$alias];
            }
        }
        return null;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->assets;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function buildUrl(string $url): string
    {
        return str_replace($this->extension, '', $url) . $this->extension;
    }

    /**
     * @param string $url
     * @param string $alias
     * @return AssetItem
     */
    protected function buildItem(string $url, string $alias)
    {
        return new AssetItem($url, $alias);
    }
}