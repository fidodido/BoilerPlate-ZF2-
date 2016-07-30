<?php

namespace Util;

use Zend\Mvc\Controller\AbstractActionController;

class BaseController extends AbstractActionController {
    /*
     * Retorna la identidad.
     * 
     * Para llamar desde el controlador de la forma:
     * 
     * $this->getUser()->can('alguna-accion');
     */

    public function getUser() {
        return $this->getServiceLocator()->get('IdentityManager')->getIdentity();
    }

    /*
     * Redirecciona a la pagina sin Acceso.
     */

    public function redirectToDenyAccess() {
        d("--- Acceso Denegado ---");
        exit();
    }

    /*
     * Redirecciona al Login.
     */

    public function redirectToLogin() {
        
    }

    /*
     * 
     */

    public function redirectToHome() {
        
    }

    /**
     * 
     */
    public function getFlashMessages() {

        $flashMessenger = $this->flashMessenger();
        $messages = array();

        if ($flashMessenger->hasMessages()) {
            $messages = $flashMessenger->getMessages();
        }

        return $messages;
    }

}
