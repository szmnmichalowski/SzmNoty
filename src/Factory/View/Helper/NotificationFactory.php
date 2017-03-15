<?php
namespace SzmNoty\Factory\View\Helper;

use Interop\Container\ContainerInterface;
use SzmNoty\Options\Options;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SzmNoty\View\Helper\Notification;

class NotificationFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param null $name
     * @param array|null $options
     * @return mixed|Notification
     */
    public function __invoke(ContainerInterface $container, $name = null, array $options = null)
    {
        $class = new Notification();
        $config = $container->get('Config');
        $config = isset($config['notifications']) ? $config['notifications'] : [];
        $optionsClass = new Options($config);

        $class->setOptions($optionsClass);

        return $class;
    }

    /**
     * For use with zend-servicemanager v2; proxies to __invoke().
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed|Notification
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator);
    }
}