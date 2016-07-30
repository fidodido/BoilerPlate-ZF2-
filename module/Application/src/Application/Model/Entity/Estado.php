<?php

namespace Application\Model\Entity;

class Estado {

    private $cod;
    private $descripcion;

    public function __construct($cod, $descripcion = null) {
        $this->cod = $cod;
        $this->descripcion = $descripcion;
    }

    function getCod() {
        return $this->cod;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

}
