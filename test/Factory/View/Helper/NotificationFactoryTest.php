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
     * @covers SzmNoty\Factory\View\Helper\NotificationFactory::createService
     * @covers SzmNoty\Factory\View\Helper\NotificationFactory::__invoke
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