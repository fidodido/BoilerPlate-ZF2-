<?php

namespace Auth\Model;

use Auth\Model\IdentityManagerInterface;
use Zend\Authentication\AuthenticationService;

class IdentityManager implements IdentityManagerInterface {

    protected $authService;

    public function __construct(AuthenticationService $authService) {
        $this->authService = $authService;
    }

    public function getAuthService() {
        return $this->authService;
    }

    public function login($identity, $credential) {

        $this->getAuthService()->getAdapter()
                ->setIdentity($identity)
                ->setCredential($credential);

        $result = $this->getAuthService()->authenticate();
        return $result;
    }

    public function logout() {
        $this->getAuthService()->getStorage()->clear();
    }

    public function hasIdentity() {
        return $this->getAuthService()->hasIdentity();
    }

    public function getIdentity() {
        return $this->getAuthService()->getIdentity();
    }

    public function storeIdentity($identity) {
        $this->getAuthService()->getStorage()->write($identity);
    }

}
