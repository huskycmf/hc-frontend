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

        $di->instanceManager()
            ->addSharedInstance($sm->get('HcFrontend\Options\ModuleOptions'),
                                'HcFrontend\Options\ModuleOptions');

        $eventManager        = $e->getApplication()->getEventManager();

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

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
        $translator = $sm->get('translator');

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
