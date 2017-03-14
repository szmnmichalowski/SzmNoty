<?php
namespace SzmNoty\View\Helper;

use Zend\View\Helper\AbstractHelper;
use SzmNotification\Controller\Plugin\Notification as Plugin;

class Notification extends AbstractHelper
{
    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * @return mixed
     */
    public function __invoke()
    {
        $plugin = $this->getNotificationPlugin();
        return $plugin;
    }

    /**
     * @return Plugin
     */
    protected function getNotificationPlugin()
    {
        if (!$this->plugin) {
            $this->plugin = new Plugin();
        }

        return $this->plugin;
    }
}