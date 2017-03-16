<?php

namespace SzmNotyTest\Factory\View\Helper;

use PHPUnit\Framework\TestCase;
use SzmNoty\Factory\View\Helper\NotificationFactory;
use SzmNoty\Options\Options;
use SzmNoty\View\Helper\Notification;
use SzmNotification\Controller\Plugin\Notification as Plugin;
use Zend\ServiceManager\ServiceLocatorInterface;

class NotificationFactoryTest extends TestCase
{
    /**
     * @var NotificationFactory
     */
    protected $factory;

    /**
     * Init test variables
     */
    public function setUp()
    {
        $this->factory = new NotificationFactory();
    }

    /**
     * @covers SzmNoty\Factory\View\Helper::createService
     * @covers SzmNoty\Factory\View\Helper::__invoke
     */
    public function testCanCreateService()
    {
        $config = [
            'notifications' => []
        ];

        $controllerPlugin = new Plugin();
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $serviceLocator->get('ControllerPluginManager')
            ->willReturn($controllerPlugin)
            ->shouldBeCalled();
        $serviceLocator->get('Config')
            ->willReturn($config)
            ->shouldBeCalled();

        $result = $this->factory->createService($serviceLocator->reveal());

        $this->assertInstanceOf(Notification::class, $result);
        $this->assertInstanceOf(Options::class, $result->getOptions());
        $this->assertInstanceOf(Plugin::class, $result->getNotificationPlugin());
    }
}