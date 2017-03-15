<?php
namespace SzmNotyTest\Options;

use PHPUnit\Framework\TestCase;
use SzmNoty\Options\Options;

class OptionsTest extends TestCase
{
    /**
     * @covers SzmNoty\Options\Options::getLibraryUrl
     * @covers SzmNoty\Options\Options::setLibraryUrl
     */
    public function testLibraryUrl()
    {
        $value = 'www.example.com';
        $data = [
            'library_url' => $value
        ];
        $options = new Options($data);

        $this->assertEquals($value, $options->getLibraryUrl());
    }
}