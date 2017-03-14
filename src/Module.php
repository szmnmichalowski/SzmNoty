<?php

namespace SzmNoty;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 * @package SzmNoty
 */
class Module implements ConfigProviderInterface
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
