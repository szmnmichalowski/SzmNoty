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
}