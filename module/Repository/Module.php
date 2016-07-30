<?php

namespace Repository;

class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/',
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'OracleRepository' => function($serviceManager) {
                    $repository = new \Repository\Entity\OracleRepository();
                    $repository->setServiceManager($serviceManager);
                    return $repository;
                },
            )
        );
    }

}
