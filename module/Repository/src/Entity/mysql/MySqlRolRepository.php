<?php

namespace Repository\Entity;

use Repository\Entity\Repository;
use Repository\Entity\RolRepositoryInterface;
use DevAdmin\Model\Entity\Rol;

class MySqlRolRepository extends Repository implements RolRepositoryInterface {

    public function find($id = null) {

        $mysqli = $this->getConnection();

        // creamos la query.
        $sql = "SELECT id as idRol, name, description FROM app_roles WHERE 1=1";

        $result = $mysqli->query($sql);

        $collection = array();

        while ($row = $result->fetch_assoc()) {
            $rol = new Rol();
            $rol->exchangeArray($row);
            $collection[] = $rol;
        }

        return $collection;
    }

    public function save(Rol $rol) {

        // 1) insertar nuevo Rol.

        $idRol = $rol->getIdRol();
        $mysqli = $this->getConnection();

        // update
        if (!isset($idRol)) {

            $stmt = $mysqli->prepare("INSERT INTO app_roles (name, description)
            VALUES (?, ?)");

            $name = $rol->getName();
            $description = $rol->getDescription();

            $stmt->bind_param('ss', $name, $description);
            $stmt->execute();

            $idRol = $mysqli->insert_id;
        } else { // insert
            $stmt = $mysqli->prepare("UPDATE app_roles set name = ?, description = ? WHERE id = ?");

            $name = $rol->getName();
            $description = $rol->getDescription();

            $stmt->bind_param('ssi', $name, $description, $idRol);
            $stmt->execute();
        }

        // borrar todo lo relacionado a ese rol.
        $mysqli->query("DELETE from app_roles_navigation where role_id = {$idRol}");
        $mysqli->query("DELETE from app_roles_permission where role_id = {$idRol}");

        // 2) Insertar navegacion
        foreach ($rol->getNavigation() as $page) {

            $stmt = $mysqli->prepare("INSERT INTO app_roles_navigation (role_id, navigation_id)
            VALUES (?, ?)");

            $navigation_id = $page->getId();

            $stmt->bind_param('ii', $idRol, $navigation_id);
            $stmt->execute();
        }

        // 3) Insertar Permisos
        foreach ($rol->getPermissionList() as $permission) {

            $stmt = $mysqli->prepare("INSERT INTO app_roles_permission (role_id, permission_id)
            VALUES (?, ?)");

            $permission_id = $permission->getIdPermission();

            $stmt->bind_param('ii', $idRol, $permission_id);
            $stmt->execute();
        }

        return true;
    }

    public function findById($idRol) {
        $mysqli = $this->getConnection();
        $sql = "SELECT id as idRol, name, description FROM app_roles WHERE id = {$idRol}";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $rol = new Rol();
        $rol->exchangeArray($row);
        return $rol;
    }

    public function findAssigned($idUser) {

        $mysqli = $this->getConnection();
        $sql = "select r.id as idRol, r.name from app_users_roles ur
                    left join app_roles r on r.id = ur.role_id
                    where ur.user_id = {$idUser}";

        $result = $mysqli->query($sql);

        $collection = array();

        while ($row = $result->fetch_assoc()) {
            $rol = new Rol();
            $rol->exchangeArray($row);
            $collection[] = $rol;
        }

        return $collection;
    }

    public function findAvailable($idUser) {

        $mysqli = $this->getConnection();
        $sql = "SELECT r.id as idRol, r.name FROM app_roles r
		where r.id not in (
			select ur.role_id from app_users_roles ur
			where ur.user_id = {$idUser}
		)";

        $result = $mysqli->query($sql);

        $collection = array();

        while ($row = $result->fetch_assoc()) {
            $rol = new Rol();
            $rol->exchangeArray($row);
            $collection[] = $rol;
        }

        return $collection;
    }

}
