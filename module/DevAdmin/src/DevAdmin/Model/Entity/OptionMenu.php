<?php

namespace DevAdmin\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;

class OptionMenu implements ArraySerializableInterface {

    private $idOption;
    private $label;
    private $type;
    private $controller;
    private $action;
    private $url;
    private $route;
    private $icon;
    private $parent;

    function getIdOption() {
        return $this->idOption;
    }

    function getLabel() {
        return $this->label;
    }

    function getType() {
        return $this->type;
    }

    function getController() {
        return $this->controller;
    }

    function getAction() {
        return $this->action;
    }

    function getUrl() {
        return $this->url;
    }

    function getRoute() {
        return $this->route;
    }

    function getIcon() {
        return $this->icon;
    }

    function getParent() {
        return $this->parent;
    }

    function setIdOption($idOption) {
        $this->idOption = $idOption;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setController($controller) {
        $this->controller = $controller;
    }

    function setAction($action) {
        $this->action = $action;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setRoute($route) {
        $this->route = $route;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

    public function exchangeArray(array $array) {
        $this->idOption = empty($array['idOption']) ? $this->idOption : $array['idOption'];
        $this->parent = empty($array['parent']) ? $this->parent : $array['parent'];
        $this->label = !isset($array['label']) ? $this->label : $array['label'];
        $this->url = !isset($array['url']) ? $this->url : $array['url'];
        $this->type = !isset($array['type']) ? $this->type : $array['type'];
        $this->controller = !isset($array['controller']) ? $this->controller : $array['controller'];
        $this->action = !isset($array['action']) ? $this->action : $array['action'];
        $this->route = !isset($array['route']) ? $this->route : $array['route'];
        $this->icon = !isset($array['icon']) ? $this->icon : $array['icon'];
    }

    public function getArrayCopy() {
        return array(
            'idOption' => $this->idOption,
            'label' => $this->label,
            'type' => $this->type,
            'controller' => $this->controller,
            'action' => $this->action,
            'url' => $this->url,
            'route' => $this->route,
            'icon' => $this->icon,
            'parent' => $this->parent
        );
    }

}
