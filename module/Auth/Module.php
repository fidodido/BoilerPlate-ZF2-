<?php

namespace Auth;

use Auth\Events\AuthListener;
use Auth\Model\IdentityManager;
use Auth\Model\AuthStorage;
use Auth\Model\Adapter\OracleAuthAdapter;
use Zend\Authentication\AuthenticationService;

class Module {

    const SESSION_NAMESPACE = 'boilerplate';

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap($e) {

        // obtenemos el manejador de eventos de la aplicacion.
        $eventManager = $e->getApplication()->getEventManager();

        // Listener que corta el flujo de la aplicacion.
        $authListener = new AuthListener();

        // se agrega al manejador de eventos.
        $authListener->attach($eventManager);
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

    public function getServiceConfig() {

        return array(
            'aliases' => array(
                'Zend\Authentication\AuthenticationService' => 'AuthService',
            ),
            'factories' => array(
                'AuthService' => function($serviceLocator) {

                    /*
                     * Dependiendo de como nos queramos identificar.
                     * 
                     * Lo primero es instanciar un adaptador.
                     *
                     */

                    // 1) Instanciamos un adaptar personalizado
                    // y le pasamos el buscador de servicios
                    // Por si necesitamos conexion a BD u otro.
                    $adapter = new OracleAuthAdapter();
                    $adapter->setServiceLocator($serviceLocator);

                    // 2) Creamos un almacen para la sesion.
                    // En la mayoria de los casos sera en la sesion por default.
                    $storage = new AuthStorage(self::SESSION_NAMESPACE);

                    // 3) Creamos un servicio de autentificacion.
                    // Este servicio sera finalmente quien llame al metodo authenticate.
                    $authService = new AuthenticationService();

                    // Le pasamos el almacen y el adaptador.
                    $authService->setAdapter($adapter);
                    $authService->setStorage($storage);


                    return $authService;
                },
                'IdentityManager' => function($serviceLocator) {

                    $authService = $serviceLocator->get('AuthService');
                    $identityManager = new IdentityManager($authService);
                    return $identityManager;
                }
            ),
        );
    }

}
