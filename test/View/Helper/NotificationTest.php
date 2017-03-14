<?php
namespace SzmNotyTest\View\Helper;

use PHPUnit\Framework\TestCase;
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
        $this->assertInstanceOf(Plugin::class, $this->notification->__invoke());
    }
}