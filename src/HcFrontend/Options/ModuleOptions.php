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
     * @var bool
     */
    protected $includeValidatorLocalizedMessages = true;

    /**
     * @param boolean $includeValidatorLocalizedMessages
     * @return $this
     */
    public function setIncludeValidatorLocalizedMessages($includeValidatorLocalizedMessages)
    {
        $this->includeValidatorLocalizedMessages = (boolean)$includeValidatorLocalizedMessages;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIncludeValidatorLocalizedMessages()
    {
        return $this->includeValidatorLocalizedMessages;
    }

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
