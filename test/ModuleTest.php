<?php
namespace SzmNotyTest;

use PHPUnit\Framework\TestCase;
use SzmNoty\Module;

class ModuleTest extends TestCase
{
    /**
     * @var Module
     */
    protected $module;

    public function setUp()
    {
        $this->module = new Module();
    }

    /**
     * @covers SzmNoty\Module::getConfig
     */
    public function testGetConfig()
    {
        $this->assertTrue(is_array($this->module->getConfig()));
    }
}