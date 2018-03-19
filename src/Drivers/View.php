<?php

namespace VS\Response\Drivers;

use VS\General\Configurable\ConfigurableConstants;
use VS\Response\ResponseInterface;

/**
 * Class View
 * @package VS\Response\Drivers
 * @author Varazdat Stepanyan
 */
class View extends AbstractDriver
{
    /**
     * @var string $viewName
     */
    protected $viewName;
    /**
     * @var string $extendsView
     */
    protected $extendsView;
    /**
     * @var array $sections
     */
    protected $sections = [];
    /**
     * @var string $activeSection
     */
    protected $activeSection;
    /**
     * @var bool $render
     */
    protected $render = false;
    /**
     * @var array $variables
     */
    protected static $variables = [];

    /**
     * View constructor.
     * @param ResponseInterface $response
     * @param string $viewName
     * @param array $data
     * @throws \Exception
     */
    public function __construct(ResponseInterface $response, string $viewName, array $data = [])
    {
        parent::__construct($response);
        $this->viewName = $viewName;
        self::$variables = array_merge(self::$variables, $data);
        $this->setContent($this->generateContent());
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasSection(string $name): bool
    {
        return isset($this->sections[$name]);
    }

    /**
     * @param string $name
     * @return void
     */
    public function section(string $name): void
    {
        $this->activeSection = $name;
        ob_start();
    }

    /**
     * @return void
     */
    public function endSection(): void
    {
        $this->sections[$this->activeSection] = ob_get_clean();
    }

    /**
     * @param string $parentViewFile
     * @return $this
     * @throws \Exception
     */
    public function extends(string $parentViewFile)
    {
        $this->extendsView = $this->prepareView($parentViewFile);
        return $this;
    }

    /**
     * @param string $sectionName
     * @return void
     */
    public function yield(string $sectionName): void
    {
        if (!empty($this->sections[$sectionName])) {
            print $this->sections[$sectionName];
        }
    }

    /**
     * @return $this
     */
    public function render()
    {
        $this->render = true;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString(): string
    {
        header('Content-Type: text/html; charset=utf-8');
        return parent::__toString();
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function generateContent(): string
    {
        function_exists('ob_gzhandler')
            ? ob_start('ob_gzhandler')
            : ob_start();
        extract(self::$variables, EXTR_OVERWRITE);

        include $this->prepareView($this->viewName) . '';
        if (null !== $this->extendsView) {
            include $this->extendsView . '';
        }

        $content = $this->render
            ? ob_flush()
            : ob_get_clean();

        if (ob_get_length()) {
            ob_end_clean();
        }

        return $content;
    }

    /**
     * @param string $fileName
     * @return mixed|string
     * @throws \Exception
     */
    protected function prepareView(string $fileName)
    {
        $fileName = str_replace('.php', '', $fileName);

        if(!$this->has('path')) {
            throw new \InvalidArgumentException(sprintf(
                ConfigurableConstants::getMessage(ConfigurableConstants::INVALID_KEY_CODE),
                'path'
            ));
        }

        $fileName = $this->getConfig('path') . str_replace('.', '/', $fileName) . '.php';

        if (!is_readable($fileName)) {
            throw new \Exception(sprintf(
                'The file %s dose not exists or is not readable.',
                $fileName
            ));
        }

        return $fileName;
    }
}
