<?php

/*
 * Adaptador tipo Fake.
 * 
 * Sirve para probar el modulo de identificacion
 * de la aplicacion sin capa de persistencia.
 */

namespace Auth\Model\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result as AuthenticationResult;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Auth\Model\Identity;

class MySqlAdapter extends AbstractAdapter implements AdapterInterface, ServiceLocatorAwareInterface {

    protected $serviceLocator;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    /**
     * 
     * Metodo que se llama desde el Identity Manager
     * Para autentificarse.
     * 
     * Siempre debe devolver un objeto tipo Result.
     * 
     * @return \Zend\Authentication\Result
     */
    public function authenticate() {

        $code = AuthenticationResult::SUCCESS;

        $messages[] = 'Authentication successful.';

        $identity = $this->getIdentity();
        $credential = $this->getCredential();

        $identityModel = $this->getServiceLocator()
                        ->get('UserRepository')->getIdentity($identity, $credential);

        // Si no logra encontrar la identidad, retorna falso.
        if (!$identityModel) {
            $code = AuthenticationResult::FAILURE;
        }

        return new AuthenticationResult($code, $identityModel, $messages);
    }

}
