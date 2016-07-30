<?php

namespace DevAdmin\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;

class Permission implements ArraySerializableInterface {

    private $idPermission;
    private $name;

    public function exchangeArray(array $array) {
        $this->idPermission = isset($array['idPermission']) ? $array['idPermission'] : $this->idPermission;
        $this->name = isset($array['name']) ? $array['name'] : $this->name;
    }

    public function getIdPermission() {
        return $this->idPermission;
    }

    public function getName() {
        return $this->name;
    }

    public function setIdPermission($idPermission) {
        $this->idPermission = $idPermission;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getArrayCopy() {
        
    }

}
