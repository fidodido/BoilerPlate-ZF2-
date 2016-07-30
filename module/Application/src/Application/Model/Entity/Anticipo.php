<?php

namespace Application\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;
use Application\Model\Entity\Solicitud;

class Anticipo extends Solicitud implements ArraySerializableInterface {

    private $fechaAbono;
    private $monto;

    function getFechaAbono() {
        return $this->fechaAbono;
    }

    function getMonto() {
        return $this->monto;
    }

    function setFechaAbono($fechaAbono) {
        $this->fechaAbono = $fechaAbono;
    }

    function setMonto($monto) {
        $this->monto = $monto;
    }

    public function exchangeArray(array $array) {
        
        //extraigo los arreglos del padre
        parent::exchangeArray($array);

        $this->fechaAbono = isset($array["fechaAbono"]) ? $array["fechaAbono"] : $this->fechaAbono;
        $this->monto = isset($array["monto"]) ? $array["monto"] : $this->monto;
    }

    public function getArrayCopy() {
        
        $array = array(
            'fechaAbono' => $this->fechaAbono,
            'monto' => $this->monto,
            'idSolicitud' => $this->idSolicitud,
            'fechaIngreso' => $this->fechaIngreso,
            'observaciones' => $this->observaciones,
            'tipo' => $this->tipo->getCodigo(),
            'estado' => $this->estado->getCod()
        );
        
        return $array;
    }

}
