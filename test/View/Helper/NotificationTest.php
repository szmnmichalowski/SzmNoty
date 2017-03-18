<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

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