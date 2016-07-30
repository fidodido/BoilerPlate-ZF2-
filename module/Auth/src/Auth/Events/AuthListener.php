<?php

namespace Auth\Events;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class AuthListener implements ListenerAggregateInterface {

    protected $listeners = array();

    public function attach(EventManagerInterface $events, $priority = 100) {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), $priority);
    }

    public function detach(EventManagerInterface $events) {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function onDispatch(MvcEvent $e) {

        // Indica si esta peticion HTTP va hacia la pantalla de identificacion.
        $toLoginUrl = false;
        $changePasswordUrl = false;

        $matches = $e->getRouteMatch();
        $controllerClass = $matches->getParam('controller');
        $action = $matches->getParam('action');

        // Identificamos si se dirige hacia el login.
        if ($controllerClass == 'Auth\Controller\Auth' && $action == "login") {
            $toLoginUrl = true;
        }

        // Identificamos si se dirige a cambiar la clave.
        if ($controllerClass == 'Auth\Controller\Auth' && $action == "cambiar-clave") {
            $changePasswordUrl = true;
        }

        // obtenemos el buscador de servicios.
        $serviceLocator = $e->getApplication()->getServiceManager();

        // con el, obtenemos el administrador de identidad.
        $authService = $serviceLocator->get('AuthService');

        // No tiene identidad y no va hacia el login.
        if (!$authService->hasIdentity() && !$toLoginUrl) {
            $this->redirectToLogin($e);
        }

        // Si es que tiene identidad.
        if ($authService->hasIdentity()) {

            // es primera ves que entra?
            if ($authService->getIdentity()->isFirstLogin() && !$changePasswordUrl) {

                $flashMessenger = $this->getFlashMessenger();
                $flashMessenger->addMessage(array(
                    'message' => 'Alto Ahí, como es tu primera vez, debes cambiar tu contraseña.',
                    'className' => 'info'
                ));

                $this->redirectToCambioClave($e);
            }

            // Si tiene identidad y se dirige hacia el Login.
            if ($authService->hasIdentity() && $toLoginUrl) {
                $this->redirectToHome($e);
            }
        }
       
    }

    /**
     * Redirige al Login.
     * 
     * @param type $e
     * @return type
     */
    private function redirectToLogin($e) {

        // creamos la URL.
        $url = $e->getRouter()->assemble(array(), array('name' => 'login'));

        // creamos la respuesta HTTP.
        $response = $e->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->sendHeaders();

        // Evitar que siga el flujo de la aplicacion.
        $stopCallBack = function($event) use ($response) {
            $event->stopPropagation();
            return $response;
        };

        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, $stopCallBack, -10000);
        return $response;
    }

    /**
     * Redirige al Home.
     * 
     * @param type $e
     * @return type
     */
    private function redirectToHome($e) {

        // creamos la URL.
        $url = $e->getRouter()->assemble(array('controller' => 'index', 'action' => 'index'), array('name' => 'application/default'));

        // creamos la respuesta HTTP.
        $response = $e->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->sendHeaders();

        // Evitar que siga el flujo de la aplicacion.
        $stopCallBack = function($event) use ($response) {
            $event->stopPropagation();
            return $response;
        };

        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, $stopCallBack, -10000);
        return $response;
    }

    /*
     * 
     */

    private function redirectToCambioClave($e) {

        // creamos la URL.
        $url = $e->getRouter()->assemble(array(), array('name' => 'cambiarClave'));

        // creamos la respuesta HTTP.
        $response = $e->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);
        $response->sendHeaders();

        // Evitar que siga el flujo de la aplicacion.
        $stopCallBack = function($event) use ($response) {
            $event->stopPropagation();
            return $response;
        };

        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, $stopCallBack, -10000);
        return $response;
    }

    /*
     * 
     */

    private function getFlashMessenger() {

        if (!$this->flashMessenger) {
            $this->flashMessenger = new FlashMessenger();
        }

        return $this->flashMessenger;
    }

}
