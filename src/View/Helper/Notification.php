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
        if ($this->isEmpty($notifications)) {
            return;
        }

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
     * Check if notifications is empty
     *
     * @param $notifications
     * @return bool
     */
    protected function isEmpty($notifications)
    {
        if (!$notifications) {
            return true;
        }

        foreach ($notifications as $notification) {
            if (empty($notification)) {
                return true;
            }
        }

        return false;
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
        $js = '<script type="text/javascript">';
        $defaultOptions = $this->getOptions()->getDefaultOptions();

        if (isset($defaultOptions['callback'])) {
            $callbacks = $defaultOptions['callback'];
            unset($defaultOptions['callback']);

            foreach ($callbacks as $name => $function) {
                $js .= '$.noty.defaults.callback.'.$name.' = '.$function.';';
            }
        }
        $json = json_encode($defaultOptions);

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