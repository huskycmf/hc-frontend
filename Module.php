<?php
namespace HcFrontend;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        /* @var $sm \Zend\ServiceManager\ServiceManager */
        $sm = $e->getApplication()->getServiceManager();

        /* @var $di \Zend\Di\Di */
        $di = $sm->get('di');

        $moduleOptions = $sm->get('HcFrontend\Options\ModuleOptions');

        $di->instanceManager()
            ->addSharedInstance($moduleOptions,
                                'HcFrontend\Options\ModuleOptions');

        $eventManager        = $e->getApplication()->getEventManager();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        if ($moduleOptions->getIncludeValidatorLocalizedMessages()) {
            $validatorTranslator = $di->newInstance('Zend\Mvc\I18n\Translator',
                                                    array('translator'=>
                                                        $sm->get('Zend\I18n\Translator\TranslatorInterface')),
                                                    false);

            $template = 'vendor/zendframework/zendframework/resources/languages/%s/Zend_Validate.php';
            foreach ($moduleOptions->getLanguages() as $lang=>$arr) {
                if (file_exists($resourcePath = sprintf($template, $arr['locale'])) ||
                    file_exists($resourcePath = sprintf($template, $lang))) {
                    $validatorTranslator->addTranslationFile('phpArray', $resourcePath, 'default', $arr['locale']);
                }
            }
            \Zend\Validator\AbstractValidator::setDefaultTranslator($validatorTranslator);
        }

        $eventManager->attach(MvcEvent::EVENT_ROUTE, array($this, 'initLocale'), -1001);
    }

    /**
     * @param MvcEvent $e
     */
    public function initLocale(MvcEvent $e)
    {
        /* @var $sm \Zend\ServiceManager\ServiceManager */
        $sm = $e->getApplication()->getServiceManager();

        /* @var $di \Zend\Di\Di */
        $di = $sm->get('di');

        /* @var $translator \Zend\I18n\Translator\Translator */
        $translator = $sm->get('Zend\I18n\Translator\TranslatorInterface');

        /* @var $config \HcFrontend\Options\ModuleOptions */
        $config = $di->get('HcFrontend\Options\ModuleOptions');

        $lang = $e->getRouteMatch()->getParam('lang');
        $supportingLanguages = $config->getLanguages();

        if (array_key_exists($lang, $supportingLanguages) !== false) {
            $translator->setLocale($supportingLanguages[$lang]['locale']);
        } else {
            if (array_key_exists($config->getDefaultLanguage(), $supportingLanguages)) {
                $translator->setLocale($supportingLanguages[$config->getDefaultLanguage()]['locale']);
            } else {
                $translator->setLocale($config->getDefaultLanguage());
            }

            if (!empty($lang)) {
                $e->getResponse()->setStatusCode(404);
                $e->getRouteMatch()->setParam('lang', '');

            }
        }

        \Locale::setDefault($translator->getLocale());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }
}
