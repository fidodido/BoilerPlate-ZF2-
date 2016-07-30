<?php

namespace Application\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;
use Application\Model\Entity\Liquidaciones;

class Haberes extends Liquidaciones implements ArraySerializableInterface {

//    private $periodoCodigo;
//    private $periodoDescripcion;
//    private $trabajadorCodigo;
//    private $trabajadorRut;
//    private $trabajadorNombre;
    private $liquidacionVariableDescripcion; //$tado_dom_dscr
    private $valor;
    private $liquidacionVariable;
    private $orden;

    function getLiquidacionVariableDescripcion() {
        return $this->liquidacionVariableDescripcion;
    }

    function setLiquidacionVariableDescripcion($liquidacionVariableDescripcion) {
        $this->liquidacionVariableDescripcion = $liquidacionVariableDescripcion;
    }

    function getValor() {
        return $this->valor;
    }

    function getLiquidacionVariable() {
        return $this->liquidacionVariable;
    }

    function getOrden() {
        return $this->orden;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setLiquidacionVariable($liquidacionVariable) {
        $this->liquidacionVariable = $liquidacionVariable;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    public function exchangeArray(array $array) {
//        $this->periodoCodigo = isset($array["periodoCodigo"]) ? $array["periodoCodigo"] : $this->periodoCodigo;
//        $this->periodoDescripcion = isset($array["periodoDescripcion"]) ? $array["periodoDescripcion"] : $this->periodoDescripcion;
//        $this->trabajadorCodigo = isset($array["trabajadorCodigo"]) ? $array["trabajadorCodigo"] : $this->trabajadorCodigo;
//        $this->trabajadorRut = isset($array["trabajadorRut"]) ? $array["trabajadorRut"] : $this->trabajadorRut;
//        $this->trabajadorNombre = isset($array["trabajadorNombre"]) ? $array["trabajadorNombre"] : $this->trabajadorNombre;
        //extraigo los arreglos del padre
        parent::exchangeArray($array);

        $this->tadoDomDescripcion = isset($array["tadoDomDescripcion"]) ? $array["tadoDomDescripcion"] : $this->tadoDomDescripcion;
        $this->valor = isset($array["valor"]) ? $array["valor"] : $this->valor;
        $this->liquidacionVariable = isset($array["liquidacionVariable"]) ? $array["liquidacionVariable"] : $this->liquidacionVariable;
        $this->orden = isset($array["orden"]) ? $array["orden"] : $this->orden;
    }

    public function getArrayCopy() {

        $array = array(
            'tadoDomDescripcion' => $this->tadoDomDescripcion,
            'valor' => $this->valor,
            'liquidacionVariable' => $this->liquidacionVariable,
            'orden' => $this->orden,
        );

        return $array;
    }

}
