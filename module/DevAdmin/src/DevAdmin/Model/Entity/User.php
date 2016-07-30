<?php

namespace DevAdmin\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;
use DevAdmin\Model\Entity\Rol;

class User implements ArraySerializableInterface {

    private $idUser;
    private $username;
    private $rolesListString;
    private $roleList;
    
    public function __construct() {
        $this->roleList = array();
    }
    
    public function getIdUser() {
        return $this->idUser;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getRolesListString() {
        return $this->rolesListString;
    }

    public function setRolesListString($rolesListString) {
        $this->rolesListString = $rolesListString;
    }

    public function getRoleList() {
        return $this->roleList;
    }

    public function setRoleList($roleList) {
        $this->roleList = $roleList;
    }

    public function exchangeArray(array $array) {
        $this->idUser = isset($array['idUser']) ? $array['idUser'] : $this->idUser;
        $this->username = isset($array['username']) ? $array['username'] : $this->username;
        $this->rolesListString = isset($array['rolelist']) ? $array['rolelist'] : $this->rolesListString;

        if (isset($array['roles']['id'])) {
            foreach ($array['roles']['id'] as $p) {
                $rol = new Rol();
                $rol->setIdRol($p);
                $this->roleList[] = $rol;
            }
        }
    }

    public function getArrayCopy() {
        return array(
            'idUser' => $this->idUser,
            'username' => $this->username
        );
    }

}
