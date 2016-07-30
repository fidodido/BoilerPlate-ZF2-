<?php

namespace Repository\Entity;

use Repository\Entity\Repository;
use DevAdmin\Model\Entity\User;
use Auth\Model\Identity;

class MySqlUserRepository extends Repository {

    public function find($id = null) {

        $mysqli = $this->getConnection();

        $sql = "select 
                u.id as idUser, 
                u.username,
                GROUP_CONCAT(r.name) as rolelist
                from app_users u
                        left join app_users_roles ur on ur.user_id = u.id
                        left join app_roles r on r.id = ur.role_id
                group by u.id";

        $result = $mysqli->query($sql);

        $collection = array();

        while ($row = $result->fetch_assoc()) {
            $user = new User();
            $user->exchangeArray($row);
            $collection[] = $user;
        }

        return $collection;
    }

    public function getIdentity($identity, $credential) {

        $mysqli = $this->getConnection();
        $sql = "SELECT id, username from app_users";
        $sql .= " WHERE username = '{$identity}' and password = '{$credential}'";

        $result = $mysqli->query($sql);

        if ($result->num_rows == 0) {
            return false;
        }

        $row = $result->fetch_assoc();

        $user_id = $row['id'];

        $identityModel = new Identity();
        $identityModel->setId($row['id']);
        $identityModel->setUsername($row['username']);

        $rbac = new \Zend\Permissions\Rbac\Rbac();

        // obtenemos los roles --
        $sql = "select * 
                from app_users_roles ur
		left join app_roles r on r.id = ur.role_id
            where ur.user_id = {$user_id}";

        $result = $mysqli->query($sql);

        $roles = array();

        while ($row = $result->fetch_assoc()) {
            $role = new \Zend\Permissions\Rbac\Role($row['name']);
            $roles[] = $role;
            $rbac->addRole($row['name']);
        }

        $identityModel->setRoles($roles);

        $sql = "select                
                r.name as rol,
                p.name as permission 
                from app_permission p
                        left join app_roles_permission rp on p.id = rp.permission_id
                        left join app_roles r on r.id = rp.role_id
                        left join app_users_roles ur on ur.role_id = r.id
                        WHERE ur.user_id = {$user_id};";

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
            $rbac->getRole($row['rol'])->addPermission($row['permission']);
        }

        $identityModel->setRbac($rbac);

        return $identityModel;
    }

    public function save(User $user) {

        $mysqli = $this->getConnection();
        $idUser = $user->getIdUser();

        // ¿ Si NO existe el ID, se inserta el nuevo registro.
        if (!isset($idUser)) {

            $stmt = $mysqli->prepare("INSERT INTO app_users (username, password)
            VALUES (?, 123)");

            $username = $user->getUsername();

            $stmt->bind_param('s', $username);
            $stmt->execute();

            $idUser = $mysqli->insert_id;
        } else {

            $stmt = $mysqli->prepare("UPDATE app_users set username = ? WHERE id = ?");
            $username = $user->getUsername();

            $stmt->bind_param('si', $username, $idUser);
            $stmt->execute();
        }

        // borrar todo lo relacionado a ese rol.
        $mysqli->query("DELETE from app_users_roles where user_id = {$idUser}");
        
        var_dump($user->getRoleList());
        
        foreach ($user->getRoleList() as $rol) {
            $rolId = $rol->getIdRol();
            $query = "INSERT INTO app_users_roles (user_id, role_id) VALUES ({$idUser}, {$rolId})";
            $mysqli->query($query);
        }



        return true;
    }

    public function findById($idUser) {
        $mysqli = $this->getConnection();
        $sql = "SELECT id as idUser, username FROM app_users WHERE id = {$idUser}";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $user = new User();
        $user->exchangeArray($row);
        return $user;
    }

}
