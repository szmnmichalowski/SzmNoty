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

    /**
     * @covers SzmNoty\View\Helper\Notification::getNotificationPlugin
     * @covers SzmNoty\View\Helper\Notification::setNotificationPlugin
     */
    public function testGetAndSetNotificationPlugin()
    {
        $obj = new Plugin();
        $hash = spl_object_hash($obj);
        $this->notification->setNotificationPlugin($obj);

        $this->assertEquals($hash, spl_object_hash($this->notification->getNotificationPlugin()));
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::getNotificationPlugin
     */
    public function testGetNotificationPlugin()
    {
        $this->assertInstanceOf(Plugin::class, $this->notification->getNotificationPlugin());
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::renderCurrent
     * @covers SzmNoty\View\Helper\Notification::renderNotifications
     * @covers SzmNoty\View\Helper\Notification::isEmpty
     */
    public function testRenderCurrentShouldReturnNullWhenNoNotifications()
    {
        $this->assertEquals(null, $this->notification->renderCurrent());
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::renderCurrent
     * @covers SzmNoty\View\Helper\Notification::renderNotifications
     * @covers SzmNoty\View\Helper\Notification::isEmpty
     */
    public function testRenderCurrentNamespaceWithNoNotifications()
    {
        $this->assertEquals(null, $this->notification->renderCurrent('test'));
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::renderCurrent
     * @covers SzmNoty\View\Helper\Notification::renderNotifications
     * @covers SzmNoty\View\Helper\Notification::isEmpty
     * @covers SzmNoty\View\Helper\Notification::renderSingleNamespace
     */
    public function testRenderCurrentNamespaceWithNotifications()
    {
        $options = $this->prophesize(Options::class);
        $options->getDefaultOptions()
            ->willReturn([])
            ->shouldBeCalled();
        $options->getType('info')
            ->willReturn([])
            ->shouldBeCalled();

        $this->notification->setOptions($options->reveal());

        $plugin = $this->notification->getNotificationPlugin();
        $plugin->add('info', 'test');

        $htmlPattern = '#<script ([\w\W]*)</script>#';
        $html = $this->notification->renderCurrent('info');
        $this->assertTrue((bool) preg_match($htmlPattern, $html));
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::renderNotifications
     * @covers SzmNoty\View\Helper\Notification::renderNotificationLibrary
     */
    public function testRenderNamespaceWithNotificationsAndLibrary()
    {
        $options = $this->prophesize(Options::class);
        $options->getDefaultOptions()
            ->willReturn([])
            ->shouldBeCalled();
        $options->getType('info')
            ->willReturn([])
            ->shouldBeCalled();
        $options->getLibraryUrl()
            ->willReturn('www.example.com')
            ->shouldBeCalled();

        $this->notification->setOptions($options->reveal());
        $this->notification->setIncludeLibrary(true);

        $plugin = $this->notification->getNotificationPlugin();
        $plugin->add('info', 'test');

        $htmlPattern = '#<script ([\w\W]*)</script>#';
        $html = $this->notification->renderCurrent('info');
        $this->assertTrue((bool) preg_match($htmlPattern, $html));
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::renderNotifications
     * @covers SzmNoty\View\Helper\Notification::renderDefaultOptions
     */
    public function testRenderNamespaceWithNotificationsAndDefaultOptions()
    {
        $defaultOptions = [
            'layout' => 'top',
            'callback' => [
                'afterClose' => 'function(){}'
            ]
        ];
        $options = $this->prophesize(Options::class);
        $options->getDefaultOptions()
            ->willReturn($defaultOptions)
            ->shouldBeCalled();
        $options->getType('info')
            ->willReturn([])
            ->shouldBeCalled();
        $options->getLibraryUrl()
            ->willReturn('www.example.com')
            ->shouldBeCalled();

        $this->notification->setOptions($options->reveal());
        $this->notification->setIncludeLibrary(true);

        $plugin = $this->notification->getNotificationPlugin();
        $plugin->add('info', 'test');

        $htmlPattern = '#<script ([\w\W]*)</script>#';
        $html = $this->notification->renderCurrent('info');
        $this->assertTrue((bool) preg_match($htmlPattern, $html));
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::render
     * @covers SzmNoty\View\Helper\Notification::renderNotifications
     * @covers SzmNoty\View\Helper\Notification::isEmpty
     */
    public function testRenderShouldReturnNullWhenNoNotifications()
    {
        $this->assertEquals(null, $this->notification->render());
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::render
     * @covers SzmNoty\View\Helper\Notification::renderNotifications
     * @covers SzmNoty\View\Helper\Notification::isEmpty
     */
    public function testRenderNamespaceWithNoNotifications()
    {
        $this->assertEquals(null, $this->notification->render('test'));
    }

    /**
     * @covers SzmNoty\View\Helper\Notification::render
     * @covers SzmNoty\View\Helper\Notification::renderNotifications
     * @covers SzmNoty\View\Helper\Notification::isEmpty
     * @covers SzmNoty\View\Helper\Notification::renderSingleNamespace
     */
    public function testRenderNamespaceWithNotifications()
    {
        $options = $this->prophesize(Options::class);
        $options->getDefaultOptions()
            ->willReturn([])
            ->shouldBeCalled();
        $options->getType('info')
            ->willReturn([])
            ->shouldBeCalled();

        $this->notification->setOptions($options->reveal());

        $plugin = $this->notification->getNotificationPlugin();
        $plugin->add('info', 'test');
        $this->notification->setNotificationPlugin(new Plugin());

        $htmlPattern = '#<script ([\w\W]*)</script>#';
        $html = $this->notification->render('info');
        $this->assertTrue((bool) preg_match($htmlPattern, $html));
    }
}