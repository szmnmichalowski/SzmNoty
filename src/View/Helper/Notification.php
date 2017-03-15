<?php
namespace SzmNoty\View\Helper;

use SzmNoty\Options\Options;
use Zend\View\Helper\AbstractHelper;
use SzmNotification\Controller\Plugin\Notification as Plugin;

class Notification extends AbstractHelper
{
    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * @var Options
     */
    protected $options;

    /**
     * @var bool
     */
    protected $includeLibrary = false;

    /**
     * @return mixed
     */
    public function __invoke()
    {
        $plugin = $this->getNotificationPlugin();
        return $plugin;
    }

    /**
     * @return Options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param Options $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return bool
     */
    public function getIncludeLibrary()
    {
        return $this->includeLibrary;
    }

    /**
     * @param bool $includeLibrary
     */
    public function setIncludeLibrary($includeLibrary)
    {
        $this->includeLibrary = $includeLibrary;
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