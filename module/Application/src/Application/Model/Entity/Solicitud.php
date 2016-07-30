<?php

namespace Application\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;
use Application\Model\Entity\Estado;
use Application\Model\Entity\Tipo;

class Solicitud implements ArraySerializableInterface {

    protected $idSolicitud;
    protected $fechaIngreso;
    protected $estado;
    protected $observaciones;
    protected $tipo;
    protected $nombreTrabajador;

    const ACTION_ACEPTAR = "ACEPTAR";
    const ACTION_RECHAZAR = "RECHAZAR";
    const ACTION_ANULAR = "ANULAR";
    const TIPO_ANTICIPO = 'ANTICIPOS';
    const TIPO_VACACIONES = 'VACACIONES';

    private $actions;

    public function __construct() {
        $this->actions = array(
            self::ACTION_ACEPTAR => 'ACEPTADO',
            self::ACTION_ANULAR => 'ANULADO',
            self::ACTION_RECHAZAR => 'RECHAZADO'
        );
    }

    public function getEstadoPorAccion($action) {
        return $this->actions[$action];
    }

    function getNombreTrabajador() {
        return $this->nombreTrabajador;
    }

    function setNombreTrabajador($nombreTrabajador) {
        $this->nombreTrabajador = $nombreTrabajador;
    }

    function getIdSolicitud() {
        return $this->idSolicitud;
    }

    function getFechaIngreso() {
        return $this->fechaIngreso;
    }

    function getEstado() {
        return $this->estado;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function setIdSolicitud($idSolicitud) {
        $this->idSolicitud = $idSolicitud;
    }

    function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function exchangeArray(array $array) {

        $this->idSolicitud = !empty($array['idSolicitud']) ? $array['idSolicitud'] : $this->idSolicitud;
        $this->fechaIngreso = !empty($array['fechaIngreso']) ? $array['fechaIngreso'] : $this->fechaIngreso;
        $this->observaciones = !empty($array['observaciones']) ? $array['observaciones'] : $this->observaciones;

        if (isset($array['estado'])) {
            $this->estado = new Estado($array['estado']);
        }

        if (isset($array['tipo'])) {
            $this->tipo = new Tipo($array['tipo']);
        }
    }

    public function getArrayCopy() {

        $array = array();

        foreach ($this as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }

}
