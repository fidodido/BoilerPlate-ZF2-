<?php

namespace Repository\Entity;

use Repository\Entity\Repository;
use DevAdmin\Model\Entity\Permission;

class MySqlPermissionRepository extends Repository {

    public function find($id = null) {

        $mysqli = $this->getConnection();
        $sql = "SELECT id as idPermission, name FROM app_permission WHERE 1=1";

        $result = $mysqli->query($sql);

        $collection = array();

        while ($row = $result->fetch_assoc()) {
            $rol = new Permission();
            $rol->exchangeArray($row);
            $collection[] = $rol;
        }

        return $collection;
    }

    public function findAssigned($role_id) {

        $mysqli = $this->getConnection();
        $sql = "select p.id as idPermission, p.name from app_roles_permission rp
                    left join app_permission p on p.id = rp.permission_id
                    where rp.role_id = {$role_id}";

        $result = $mysqli->query($sql);

        $collection = array();

        while ($row = $result->fetch_assoc()) {
            $rol = new Permission();
            $rol->exchangeArray($row);
            $collection[] = $rol;
        }

        return $collection;
    }

    public function findAvailable($idRol) {

        $mysqli = $this->getConnection();
        $sql = "SELECT p.id as idPermission, p.name FROM app_permission p
		where p.id not in (
			select rp.permission_id from app_roles_permission rp
			where rp.role_id = {$idRol}
		)";

        $result = $mysqli->query($sql);

        $collection = array();

        while ($row = $result->fetch_assoc()) {
            $rol = new Permission();
            $rol->exchangeArray($row);
            $collection[] = $rol;
        }

        return $collection;
    }

    public function save(Permission $per) {
        $mysqli = $this->getConnection();
        $name = $per->getName();
        $stmt = $mysqli->prepare("INSERT INTO app_permission (name) VALUES (?)");
        $stmt->bind_param('s', $name);
        $stmt->execute();
    }

}
