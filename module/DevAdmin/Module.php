<?php

namespace DevAdmin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use DevAdmin\Event\RequirementListener;

class Module {

    public function onBootstrap(MvcEvent $e) {

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $authListener = new RequirementListener();
        $authListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), 100);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /*
     * Si ocurre un error y 
     * podemos 
     */

    function onDispatchError(MvcEvent $e) {

        $vm = $e->getViewModel();
        $vm->setTemplate('layout/devadmin');
    }

}
