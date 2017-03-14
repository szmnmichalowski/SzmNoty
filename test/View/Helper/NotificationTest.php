<?php
namespace SzmNotyTest\View\Helper;

use PHPUnit\Framework\TestCase;
use SzmNoty\View\Helper\Notification;

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
}