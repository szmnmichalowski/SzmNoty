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

    public function testIfArraysKeysAreValidWithSetters()
    {
        $data = [
            'library_url' => '',
            'default_options' => [],
            'types' => [],
        ];

        $options = new Options($data);
        $this->assertEquals('', $options->getLibraryUrl());
        $this->assertEquals([], $options->getDefaultOptions());
        $this->assertEquals([], $options->getTypes());
    }
}