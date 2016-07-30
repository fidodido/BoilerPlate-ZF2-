<?php

namespace Auth\Model\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result as AuthenticationResult;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Esta clase funciona como un adaptar para ORACLE.
 * 
 * Los Requerimientos debe ser tener la conexion a oracle.
 * 
 * Y se debe sobre-escribir la funcion authenticate.
 */
class OracleAuthAdapter extends AbstractAdapter implements AdapterInterface, ServiceLocatorAwareInterface {

    protected $adapter;
    protected $serviceLocator;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function authenticate() {

        $config = $this->getServiceLocator()->get('Config');

        // tratamos de conectarnos con oracle.
        $username = $this->getIdentity();
        $credential = $this->getCredential();
        $connectionString = $config['oradb']['connection_string'];

        // Para comprobar si nos podemos conectar
        if (!function_exists('oci_connect')) {
            throw new Exception("La extension OCI No esta instalada", -1);
        }

        $conn = @oci_connect($username, $credential, $connectionString);

        if ($conn === false) {
            $code = AuthenticationResult::FAILURE;
            $messages[] = 'No se pudo identificar. Intente de nuevo por favor. (Primer intento).';
            $identityModel = false;
        } else {

            $code = AuthenticationResult::SUCCESS;
            $messages[] = 'Autentificado correctamente';

            // sobre-escribimos la configuracion con las credenciales.
            $config['oradb']['username'] = $username;
            $config['oradb']['password'] = $credential;

            $this->getServiceLocator()->setAllowOverride(true);
            $this->getServiceLocator()->setService('Config', $config);
            $this->getServiceLocator()->setAllowOverride(false);
            
            $identityModel = $this->getServiceLocator()
                            ->get(\Repository\Entity\Repository::ORACLE)->getIdentity($username, $credential);
            
        }

        return new AuthenticationResult($code, $identityModel, $messages);
    }

}
