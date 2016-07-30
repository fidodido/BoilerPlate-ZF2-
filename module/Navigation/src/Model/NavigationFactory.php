<?php

namespace Navigation\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NavigationFactory implements FactoryInterface {

    /**
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return type
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $navigation = new Navigation();
        return $navigation->createService($serviceLocator);
    }

}
