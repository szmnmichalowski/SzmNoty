<?php
namespace SzmNotyTest\Options;

use PHPUnit\Framework\TestCase;
use SzmNoty\Options\Options;

class OptionsTest extends TestCase
{
    /**
     * @var Options
     */
    protected $options;

    public function setUp()
    {
        $this->options = new Options();
    }
}