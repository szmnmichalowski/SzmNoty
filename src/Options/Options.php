<?php
namespace SzmNoty\Options;

use Zend\Stdlib\AbstractOptions;

class Options extends AbstractOptions
{
    /**
     * @var string
     */
    protected $libraryUrl = '';

    /**
     * @var array
     */
    protected $types = [];

    /**
     * @return string
     */
    public function getLibraryUrl()
    {
        return $this->libraryUrl;
    }

    /**
     * @param string $libraryUrl
     */
    public function setLibraryUrl($libraryUrl)
    {
        $this->libraryUrl = $libraryUrl;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Get single type
     *
     * @param $name
     * @return array|mixed
     */
    public function getType($name) {
        return isset($this->types[$name]) ? $this->types[$name] : [];
    }

    /**
     * @param array $types
     */
    public function setTypes($types)
    {
        $this->types = $types;
    }
}