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
    public function testGetAndSetLibraryUrl()
    {
        $value = 'www.example.com';
        $data = [
            'library_url' => $value
        ];
        $options = new Options($data);

        $this->assertEquals($value, $options->getLibraryUrl());
    }

    /**
     * @covers SzmNoty\Options\Options::getTypes
     * @covers SzmNoty\Options\Options::setTypes
     */
    public function testGetAndSetTypes()
    {
        $data = [
            'foo' => [
                'bar'
            ]
        ];

        $options = new Options();
        $options->setTypes($data);
        $this->assertEquals($data, $options->getTypes());
    }

    /**
     * @covers SzmNoty\Options\Options::getType
     */
    public function testGetSingleType()
    {
        $name = 'foo';
        $data = [
            'types' => [
                $name => [
                    'bar'
                ]
            ]
        ];

        $options = new Options($data);
        $this->assertEquals($data['types'][$name], $options->getType($name));
    }

    /**
     * @covers SzmNoty\Options\Options::setDefaultOptions
     * @covers SzmNoty\Options\Options::getDefaultOptions
     */
    public function testGetAndSetDefaultOptions()
    {
        $data = [
                'foo' => 'bar'
        ];

        $options = new Options();
        $options->setDefaultOptions($data);
        $this->assertEquals($data, $options->getDefaultOptions());
    }
}