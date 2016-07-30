<?php

namespace Navigation\Model;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class Navigation extends DefaultNavigationFactory {

    protected function getPages(ServiceLocatorInterface $serviceLocator) {

        $navigation = $serviceLocator->get('OracleRepository')->findNavigationByIdentity();

        $mvcEvent = $serviceLocator->get('Application')
                ->getMvcEvent();

        $routeMatch = $mvcEvent->getRouteMatch();
        $router = $mvcEvent->getRouter();
        $pages = $this->getPagesFromConfig($navigation);

        $this->pages = $this->injectComponents(
                $pages, $routeMatch, $router
        );


        return $this->pages;
    }

}
