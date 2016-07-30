<?php

namespace DevAdmin\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;
use DevAdmin\Model\Entity\Permission;
use DevAdmin\Model\Entity\Page;

class Rol implements ArraySerializableInterface {

    private $idRol;
    private $name;
    private $description;
    // relacion con la navegacion.
    private $navigation;
    // relacion con los permisos.
    private $permissionList;

    public function __construct() {
        $this->navigation = array();
        $this->permissionList = array();
    }

    public function getIdRol() {
        return $this->idRol;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getNavigation() {
        return $this->navigation;
    }

    public function getPermissionList() {
        return $this->permissionList;
    }

    public function setNavigation($navigation) {
        $this->navigation = $navigation;
    }

    public function setPermissionList($permissionList) {
        $this->permissionList = $permissionList;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function exchangeArray(array $array) {

        $this->idRol = isset($array['idRol']) ? $array['idRol'] : $this->idRol;
        $this->name = isset($array['name']) ? $array['name'] : $this->name;
        $this->description = isset($array['description']) ? $array['description'] : $this->description;

        if (isset($array['pages'])) {
            foreach ($array['pages'] as $p) {
                if ($p['checked'] === "1") {
                    $page = new Page();
                    $page->setId($p['id']);
                    $this->navigation[] = $page;
                }
            }
        }

        if (isset($array['permission']['id'])) {
            foreach ($array['permission']['id'] as $p) {
                $permission = new Permission();
                $permission->setIdPermission($p);
                $this->permissionList[] = $permission;
            }
        }
    }

    public function getArrayCopy() {
        return array(
            'idRol' => $this->idRol,
            'name' => $this->name,
            'description' => $this->description
        );
    }

}
