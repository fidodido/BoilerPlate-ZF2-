<?php

namespace Application\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;
//use Application\Model\Entity\Estado;

class Cumpleanos implements ArraySerializableInterface {

    private $idUsuario;
    private $fechaNacimiento;
    private $nombre;
    private $rut;
    
    function getRut() {
        return $this->rut;
    }

    function setRut($rut) {
        $this->rut = $rut;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    
    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }
    
    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }
    
    function getMonth() {
        return substr($this->fechaNacimiento, 3, 2);
    }

    public function exchangeArray(array $array) {

        $this->rut = !empty($array['rut']) ? $array['rut'] : $this->rut;
        $this->idUsuario = !empty($array['idUsuario']) ? $array['idUsuario'] : $this->idUsuario;
        $this->nombre = !empty($array['nombre']) ? $array['nombre'] : $this->nombre;
        $this->fechaNacimiento = !empty($array['fechaNacimiento']) ? $array['fechaNacimiento'] : $this->fechaNacimiento;
    }

    public function getArrayCopy() {
        return array(
            'idUsuario' => $this->idUsuario,
            'fechaNacimiento' => $this->fechaNacimiento
        );
    }

}