<?php

namespace Application\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;

class Liquidaciones implements ArraySerializableInterface {

    private $periodoCodigo;
    private $periodoDescripcion;
    private $empresaCodigo;
    private $empresaNombre;
    private $empresaRut;
    private $empresaDireccion;
    private $empresaCiudad;
    private $trabajadorCodigo;
    private $trabajadorRut;
    private $trabajadorNombre; //$nombre
    private $trabajadorFechaIngreso;
    private $conCostoCodigo;
    private $cargo; //$detr_cargo
    private $afp;
    private $isapre;
    private $banco;
    private $liquido;

    function getPeriodoCodigo() {
        return $this->periodoCodigo;
    }

    function getPeriodoDescripcion() {
        return $this->periodoDescripcion;
    }

    function getEmpresaCodigo() {
        return $this->empresaCodigo;
    }

    function getEmpresaNombre() {
        return $this->empresaNombre;
    }

    function getEmpresaRut() {
        return $this->empresaRut;
    }

    function getEmpresaDireccion() {
        return $this->empresaDireccion;
    }

    function getEmpresaCiudad() {
        return $this->empresaCiudad;
    }

    function getTrabajadorCodigo() {
        return $this->trabajadorCodigo;
    }

    function getTrabajadorRut() {
        return $this->trabajadorRut;
    }

    function getTrabajadorNombre() {
        return $this->trabajadorNombre;
    }

    function getTrabajadorFechaIngreso() {
        return $this->trabajadorFechaIngreso;
    }

    function getConCostoCodigo() {
        return $this->conCostoCodigo;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getAfp() {
        return $this->afp;
    }

    function getIsapre() {
        return $this->isapre;
    }

    function getBanco() {
        return $this->banco;
    }

    function getLiquido() {
        return $this->liquido;
    }

    function setPeriodoCodigo($periodoCodigo) {
        $this->periodoCodigo = $periodoCodigo;
    }

    function setPeriodoDescripcion($periodoDescripcion) {
        $this->periodoDescripcion = $periodoDescripcion;
    }

    function setEmpresaCodigo($empresaCodigo) {
        $this->empresaCodigo = $empresaCodigo;
    }

    function setEmpresaNombre($empresaNombre) {
        $this->empresaNombre = $empresaNombre;
    }

    function setEmpresaRut($empresaRut) {
        $this->empresaRut = $empresaRut;
    }

    function setEmpresaDireccion($empresaDireccion) {
        $this->empresaDireccion = $empresaDireccion;
    }

    function setEmpresaCiudad($empresaCiudad) {
        $this->empresaCiudad = $empresaCiudad;
    }

    function setTrabajadorCodigo($trabajadorCodigo) {
        $this->trabajadorCodigo = $trabajadorCodigo;
    }

    function setTrabajadorRut($trabajadorRut) {
        $this->trabajadorRut = $trabajadorRut;
    }

    function setTrabajadorNombre($trabajadorNombre) {
        $this->trabajadorNombre = $trabajadorNombre;
    }

    function setTrabajadorFechaIngreso($trabajadorFechaIngreso) {
        $this->trabajadorFechaIngreso = $trabajadorFechaIngreso;
    }

    function setConCostoCodigo($conCostoCodigo) {
        $this->conCostoCodigo = $conCostoCodigo;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function setAfp($afp) {
        $this->afp = $afp;
    }

    function setIsapre($isapre) {
        $this->isapre = $isapre;
    }

    function setBanco($banco) {
        $this->banco = $banco;
    }

    function setLiquido($liquido) {
        $this->liquido = $liquido;
    }

    public function exchangeArray(array $array) {
        $this->periodoCodigo = isset($array["periodoCodigo"]) ? $array["periodoCodigo"] : $this->periodoCodigo;
        $this->periodoDescripcion = isset($array["periodoDescripcion"]) ? $array["periodoDescripcion"] : $this->periodoDescripcion;

        $this->empresaCodigo = isset($array["empresaCodigo"]) ? $array["empresaCodigo"] : $this->empresaCodigo;
        $this->empresaNombre = isset($array["empresaNombre"]) ? $array["empresaNombre"] : $this->empresaNombre;
        $this->empresaRut = isset($array["empresaRut"]) ? $array["empresaRut"] : $this->empresaRut;
        $this->empresaDireccion = isset($array["empresaDireccion"]) ? $array["empresaDireccion"] : $this->empresaDireccion;
        $this->empresaCiudad = isset($array["empresaCiudad"]) ? $array["empresaCiudad"] : $this->empresaCiudad;

        $this->trabajadorCodigo = isset($array["trabajadorCodigo"]) ? $array["trabajadorCodigo"] : $this->trabajadorCodigo;
        $this->trabajadorRut = isset($array["trabajadorRut"]) ? $array["trabajadorRut"] : $this->trabajadorRut;
        $this->trabajadorNombre = isset($array["trabajadorNombre"]) ? $array["trabajadorNombre"] : $this->trabajadorNombre;
        $this->trabajadorFechaIngreso = isset($array["trabajadorFechaIngreso"]) ? $array["trabajadorFechaIngreso"] : $this->trabajadorFechaIngreso;

        $this->conCostoCodigo = isset($array["conCostoCodigo"]) ? $array["conCostoCodigo"] : $this->conCostoCodigo;
        $this->cargo = isset($array["cargo"]) ? $array["cargo"] : $this->cargo;
        $this->afp = isset($array["afp"]) ? $array["afp"] : $this->afp;
        $this->isapre = isset($array["isapre"]) ? $array["isapre"] : $this->isapre;
        $this->banco = isset($array["banco"]) ? $array["banco"] : $this->banco;
        $this->liquido = isset($array["liquido"]) ? $array["liquido"] : $this->liquido;
    }

    public function getArrayCopy() {

        $array = array();

        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }

}