<?php

/*
 *
 * Esta es la clase Identidad.
 * 
 * Es el objeto que se debe crear en la persistencia de datos.
 * 
 * Dependiendo de la aplicacion, puede tener los roles asociados.
 * 
 * O lo que sea conveniente para la aplicacion.
 */

namespace Auth\Model;

class Identity {

    private $id;
    private $username;
    private $nombreCompleto;
    private $credential;
    private $rut;
    private $mail;
    private $rbac;
    private $roles;
    private $firstLogin;

    function setFirstLogin($firstLogin) {
        $this->firstLogin = $firstLogin;
    }

    function isFirstLogin() {
        return $this->firstLogin == 0 ? true : false;
    }

    function getCredential() {
        return $this->credential;
    }

    function setCredential($credential) {
        $this->credential = $credential;
    }

    function getNombreCompleto() {
        return $this->nombreCompleto;
    }

    function setNombreCompleto($nombreCompleto) {
        $this->nombreCompleto = $nombreCompleto;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getRbac() {
        return $this->rbac;
    }

    public function setRbac($rbac) {
        $this->rbac = $rbac;
    }

    public function getRoles() {
        return $this->roles;
    }

    public function setRoles($roles) {
        $this->roles = $roles;
    }

    function getRut() {
        return $this->rut;
    }

    function setRut($rut) {
        $this->rut = $rut;
    }

    public function can($permission) {

        $havePermission = false;

        /* @var $rbac \Zend\Permissions\Rbac\Rbac */
        $rbac = $this->getRbac();

        foreach ($this->getRoles() as $rol) {
            if ($rbac->isGranted($rol->getName(), $permission)) {
                $havePermission = true;
                break;
            }
        }

        return $havePermission;
    }

    public function hasRole($name) {
        return $this->rbac->hasRole($name);
    }

}
