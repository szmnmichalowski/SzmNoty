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
    protected $notificationPlugin;

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
    protected function renderNotifications($notifications, array $options = [])
    {
        $js = '';
        if ($this->getIncludeLibrary()) {
            $js .= $this->renderNotificationLibrary();
        }

        if (!empty($this->options->getDefaultOptions())) {
            $js .= $this->renderDefaultOptions();
        }

        $js .= '<script type="text/javascript">';
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
    public function renderCurrent($namespace = null, array $options = [])
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
    public function render($namespace = null, array $options = [])
    {
        $notifications = [];
        $plugin = $this->getNotificationPlugin();

        if (!$namespace) {
            $notifications = $plugin->getAll();
        } else {
            $notifications[$namespace] = $plugin->get($namespace);
        }

        return $this->renderNotifications($notifications, $options);
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
     * Return javascript code with noty library
     *
     * @return string
     */
    protected function renderNotificationLibrary()
    {
        return '<script type="text/javascript" src="'.$this->options->getLibraryUrl().'"></script>';
    }

    /**
     * Return javascript code to overwrite default options
     *
     * @return string
     */
    protected function renderDefaultOptions()
    {
        $json = json_encode($this->getOptions()->getDefaultOptions());

        $js = '<script type="text/javascript">';
        $js .= 'Object.assign($.noty.defaults, '.$json.');';
        $js .= '</script>';

        return $js;
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
     * @return $this
     */
    public function setIncludeLibrary($includeLibrary)
    {
        $this->includeLibrary = $includeLibrary;
        return $this;
    }

    /**
     * @return Plugin
     */
    public function getNotificationPlugin()
    {
        if (!$this->notificationPlugin) {
            $this->notificationPlugin = new Plugin();
        }

        return $this->notificationPlugin;
    }

    /**
     * @param Plugin $plugin
     * @return $this
     */
    public function setNotificationPlugin($plugin)
    {
        $this->notificationPlugin = $plugin;
        return $this;
    }
}