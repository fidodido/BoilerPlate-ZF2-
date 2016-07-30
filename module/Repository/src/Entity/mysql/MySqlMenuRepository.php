<?php

namespace Repository\Entity;

use Repository\Entity\Repository;
use Repository\Entity\MenuRepositoryInterface;
use DevAdmin\Model\Entity\OptionMenu;

class MySqlMenuRepository extends Repository implements MenuRepositoryInterface {

    public function find($id = null, $parent = null) {

        $mysqli = $this->getConnection();

        // creamos la query.
        $sql = "SELECT * FROM app_navigation WHERE 1=1";

        $result = $mysqli->query($sql);

        $rows = array();

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $config = array();

        // cramos el array
        foreach ($rows as $r) {

            if ($r['parent'] === $parent) {

                $page = array(
                    'label' => $r['title'],
                    'uri' => $r['url'],
                    'type' => $r['type'],
                    'controller' => $r['controller'],
                    'action' => $r['action'],
                    'route' => $r['route'],
                    'id' => $r['id'],
                    'icon' => $r['icon'],
                    'pages' => array()
                );

                foreach ($rows as $s) {

                    if ($s['parent'] == $r['id']) {
                        $sub = array(
                            'label' => $s['title'],
                            'uri' => $s['url'],
                            'type' => $s['type'],
                            'controller' => $s['controller'],
                            'action' => $s['action'],
                            'route' => $s['route'],
                            'icon' => $s['icon'],
                            'id' => $s['id']
                        );

                        $page['pages'][] = $sub;
                    }
                }

                $config[] = $page;
            }
        }


        return $config;
    }

    public function findPagesByRol($role_id, $parent = null) {

        $mysqli = $this->getConnection();

        // creamos la query.
        $sql = "SELECT 
                nav.id, 
                nav.title,
                nav.parent,
                nav.icon,
                case WHEN
                (select 
                    rn.role_id
                    from app_roles_navigation rn
                    where role_id = {$role_id} AND rn.navigation_id = nav.id
                )
                IS NULL THEN 0
                ELSE 1
                END as checked
                FROM app_navigation nav";

        $result = $mysqli->query($sql);

        $rows = array();

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $config = array();

        // cramos el array
        foreach ($rows as $r) {

            if ($r['parent'] === $parent) {

                $page = array(
                    'label' => $r['title'],
                    'id' => $r['id'],
                    'icon' => $r['icon'],
                    'parent' => $r['parent'],
                    'checked' => $r['checked']
                );

                foreach ($rows as $s) {

                    if ($s['parent'] == $r['id']) {
                        $sub = array(
                            'label' => $s['title'],
                            'id' => $s['id'],
                            'icon' => $s['icon'],
                            'parent' => $s['parent'],
                            'checked' => $s['checked']
                        );

                        $page['pages'][] = $sub;
                    }
                }

                $config[] = $page;
            }
        }


        return $config;
    }

    public function save(OptionMenu $option) {

        $mysqli = $this->getConnection();

        $id = $option->getIdOption();
        $label = $option->getLabel();
        $parent = $option->getParent();
        $controller = $option->getController();
        $action = $option->getAction();
        $route = $option->getRoute();
        $icon = $option->getIcon();
        $type = $option->getType();
        $url = $option->getUrl();

        if (isset($id)) {

            $sql = 'UPDATE app_navigation';
            $sql .= ' set title = ?, route = ?, controller = ?, action = ?, type = ?, ';
            $sql .= ' url = ?, icon = ?, parent = ? WHERE id = ?';

            $stmt = $mysqli->prepare($sql);

            $stmt->bind_param('sssssssii', $label, $route, $controller, $action, $type, $url, $icon, $parent, $id);
            $stmt->execute();
        } else {

            $stmt = $mysqli->prepare("INSERT INTO app_navigation (title, route, controller, action, type, url, icon, parent)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param('sssssssi', $label, $route, $controller, $action, $type, $url, $icon, $parent);
            $stmt->execute();
        }

        $mysqli = $this->getConnection();
        return true;
    }

    public function findByIdentity($id = null, $parent = null) {

        $identity = $this->getServiceManager()->get('IdentityManager')->getIdentity();

        $roleList = array();

        foreach ($identity->getRoles() as $rol) {
            $roleList[] = "'" . $rol->getName() . "'";
        }

        $roleCommas = implode(",", $roleList);

        $mysqli = $this->getConnection();

        // creamos la query.
        $sql = "SELECT 
                nav.id,
                nav.title,
                nav.route,
                nav.controller,
                nav.action,
                nav.type,
                nav.url,
                nav.icon,
                nav.parent
                FROM app_roles_navigation rolnav
                left join app_navigation nav on nav.id = rolnav.navigation_id
                left join app_roles r on r.id = rolnav.role_id
                 where r.name in({$roleCommas})
                 group by nav.id";


        $result = $mysqli->query($sql);

        $rows = array();

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $config = array();

        // cramos el array
        foreach ($rows as $r) {

            if ($r['parent'] === $parent) {

                $page = array(
                    'label' => $r['title'],
                    'uri' => $r['url'],
                    'type' => $r['type'],
                    'controller' => $r['controller'],
                    'action' => $r['action'],
                    'route' => $r['route'],
                    'id' => $r['id'],
                    'icon' => $r['icon'],
                    'pages' => array()
                );

                foreach ($rows as $s) {

                    if ($s['parent'] == $r['id']) {
                        $sub = array(
                            'label' => $s['title'],
                            'uri' => $s['url'],
                            'type' => $s['type'],
                            'controller' => $s['controller'],
                            'action' => $s['action'],
                            'route' => $s['route'],
                            'icon' => $s['icon'],
                            'id' => $s['id']
                        );

                        $page['pages'][] = $sub;
                    }
                }

                $config[] = $page;
            }
        }


        return $config;
    }

    public function findById($id) {

        $mysqli = $this->getConnection();

        $sql = "SELECT id as idOption, title as label, type, controller, action, url, route, icon, parent FROM app_navigation WHERE id = {$id}";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        $option = new OptionMenu();
        $option->exchangeArray($row);

        return $option;
    }

}
