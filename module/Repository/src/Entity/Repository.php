<?php

namespace Repository\Entity;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Application\Persistence\padremu\padremuService;

class Repository implements ServiceManagerAwareInterface {

    const ORACLE = 'OracleRepository';

    protected $serviceManager;
    protected $oracleServices;

    /**
     * @param ServiceManager $serviceManager
     * @return Form
     */
    public function setServiceManager(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function getServiceManager() {
        return $this->serviceManager;
    }

    public function getConnection() {
        return $this->serviceManager->get('db')->getDriver()->getConnection()->getResource();
    }

    protected function getOracleServices() {

        if (!$this->oracleServices) {

            $connection = $this->getServiceManager()->get('OracleAdapter')
                    ->getDriver()
                    ->getConnection()
                    ->getResource();

            $this->oracleServices = new padremuService($connection);
        }

        return $this->oracleServices;
    }

    protected function getUser() {
        return $this->getServiceManager()->get('IdentityManager')->getIdentity();
    }

}
