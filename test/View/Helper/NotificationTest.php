<?php
namespace SzmNotyTest\View\Helper;

use PHPUnit\Framework\TestCase;
use SzmNoty\Options\Options;
use SzmNoty\View\Helper\Notification;
use SzmNotification\Controller\Plugin\Notification as Plugin;

class NotificationTest extends TestCase
{
    /**
     * @var Notification
     */
    protected $notification;

    public function setUp()
    {
        $this->notification = new Notification();
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::__invoke
     * @covers SzmNoty\View\Helper\Notification::getNotificationPlugin
     */
    public function testInvokeWithNoParams()
    {
        $this->assertInstanceOf(Notification::class, $this->notification->__invoke());
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::getOptions
     * @covers SzmNoty\View\Helper\Notification::setOptions
     */
    public function testGetAndSetOptions()
    {
        $options = new Options();
        $this->notification->setOptions($options);

        $this->assertInstanceOf(Options::class, $this->notification->getOptions());
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::getIncludeLibrary
     * @covers SzmNoty\View\Helper\Notification::setIncludeLibrary
     */
    public function testGetAndSetIncludeLibrary()
    {
        $this->assertFalse($this->notification->getIncludeLibrary());

        $this->notification->setIncludeLibrary(true);

        $this->assertTrue($this->notification->getIncludeLibrary());
    }
}