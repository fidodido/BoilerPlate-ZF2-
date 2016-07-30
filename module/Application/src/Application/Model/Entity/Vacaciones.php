<?php

namespace Application\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;
use Application\Model\Entity\Solicitud;
//use Application\Model\Entity\Tipo;
//use Application\Model\Entity\Estado;

class Vacaciones extends Solicitud implements ArraySerializableInterface {

    private $fechaInicio;
    private $fechaTermino;
    private $diasHabiles;

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaTermino() {
        return $this->fechaTermino;
    }

    function getDiasHabiles() {
        return $this->diasHabiles;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaTermino($fechaTermino) {
        $this->fechaTermino = $fechaTermino;
    }

    function setDiasHabiles($diasHabiles) {
        $this->diasHabiles = $diasHabiles;
    }

    public function exchangeArray(array $array) {

        //extraigo los arreglos del padre
        parent::exchangeArray($array);

        $this->fechaInicio = isset($array["fechaInicio"]) ? $array["fechaInicio"] : $this->fechaInicio;
        $this->fechaTermino = isset($array["fechaTermino"]) ? $array["fechaTermino"] : $this->fechaTermino;
        $this->diasHabiles = isset($array["diasHabiles"]) ? $array["diasHabiles"] : $this->diasHabiles;
        
    }

    public function getArrayCopy() {

        $array = array(
            'fechaInicio' => $this->fechaInicio,
            'fechaTermino' => $this->fechaTermino,
            'diasHabiles' => $this->diasHabiles,
            'idSolicitud' => $this->idSolicitud,
            'fechaIngreso' => $this->fechaIngreso,
            'observaciones' => $this->observaciones,
            'tipo' => $this->tipo->getCodigo(),
            'estado' => $this->estado->getCod(),
            'descripcion' => $this->estado->getDescripcion(),
        );
        
        //d($array);
        
        return $array;
    }

}
