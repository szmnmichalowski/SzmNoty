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
        return $this;
    }

    /**
     * Return javascript code
     *
     * @param $notifications
     * @param array $options
     * @return string
     */
    protected function renderNotifications($notifications, $options = [])
    {
        $js = '<script type="text/javascript">';
        foreach ($notifications as $type => $notification) {
            $js .= $this->renderSingleNamespace($type, $notification, $options);
        }
        $js .= '</script>';

        return $js;
    }

    /**
     * Render current notifications
     *
     * @param null $namespace
     * @param array $options
     * @return string
     */
    public function renderCurrent($namespace = null, $options = [])
    {
        $notifications = [];
        $plugin = $this->getNotificationPlugin();

        if (!$namespace) {
            $notifications = $plugin->getAllCurrent();
        } else {
            $notifications[$namespace] = $plugin->getCurrent($namespace);
        }

        return $this->renderNotifications($notifications, $options);
    }

    /**
     * Render notifications from previous requests
     *
     * @param null $namespace
     * @param array $options
     * @return string
     */
    public function render($namespace = null, $options = [])
    {
        $jsCode = '';
        $notifications = [];
        $plugin = $this->getNotificationPlugin();

        if (!$namespace) {
            $notifications = $plugin->getAll();
        } else {
            $notifications[$namespace] = $plugin->get($namespace);
        }

        $jsCode .= $this->renderNotifications($notifications, $options);
        return $jsCode;
    }

    /**
     * Get javascript code for single namespace
     *
     * @param $type
     * @param $notifications
     * @param array $options
     * @return string
     */
    protected function renderSingleNamespace($type, $notifications, $options = [])
    {
        $script = '';
        $defaultOptions = $this->options->getType($type);
        $mergedOptions = array_merge($defaultOptions, $options);

        foreach ($notifications as $notification) {
            $mergedOptions['text'] = $notification;
            $json = json_encode($mergedOptions);

            $script .= "noty({$json});";
        }

        return $script;
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