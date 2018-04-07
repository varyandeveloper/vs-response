<?php

use VS\Response\Decorators\AssetInterface;
use VS\Response\Decorators\AssetItem\AssetItemInterface;

/**
 * Class ResponseTest
 */
class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \VS\Response\ResponseInterface $responseFactory
     */
    protected $responseFactory;

    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
        \VS\Response\ResponseConstants::setViewPath(__DIR__ . '/view/');
    }

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->responseFactory = new \VS\Response\Response();
    }

    public function testView()
    {
        $view = $this->responseFactory->view('test-view');
        $this->assertInstanceOf(\VS\Response\Drivers\View::class, $view);

        $view->addAssets(function (AssetInterface $script, AssetInterface $style) {
            $script->append('/js/home', 'home');
            $script->append('/js/about', 'about');

            $style->prepend('/css/home', 'home');
            $style->prepend('/css/about', 'about');
        });

        $this->assertCount(2, $view->getScripts());
        $this->assertContainsOnly(AssetItemInterface::class, $view->getScripts());
    }
}