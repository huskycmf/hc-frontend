<?php
namespace HcFrontend\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $defaultLanguage;

    /**
     * @var array
     */
    protected $languages = array();

    /**
     * @param string $defaultLanguage
     * @return $this
     */
    public function setDefaultLanguage($defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * @param array $languages
     * @return $this
     */
    public function setLanguages(array $languages)
    {
        $this->languages = $languages;
        return $this;
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }
}
