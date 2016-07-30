<?php
namespace Application\Persistence\padremu;

class RmwgetlstsolicitudesRs {

	// array.
	public $tipo;	
	public $id_solic;	
	public $trab_codigo;	
	public $trab_rut;	
	public $trab_nombres;	
	public $fecha_solic;	
	public $fecha_solic_fmt;	
	public $cod_estado;	
	public $tado_dom_dscr;	
	public $obs;	
	
	
	public function getTipo () {
            return $this->tipo;
	}

	public function setTipo($tipo) {
            $this->tipo = $tipo;
        }
	
	
	public function getId_solic () {
            return $this->id_solic;
	}

	public function setId_solic($id_solic) {
            $this->id_solic = $id_solic;
        }
	
	
	public function getTrab_codigo () {
            return $this->trab_codigo;
	}

	public function setTrab_codigo($trab_codigo) {
            $this->trab_codigo = $trab_codigo;
        }
	
	
	public function getTrab_rut () {
            return $this->trab_rut;
	}

	public function setTrab_rut($trab_rut) {
            $this->trab_rut = $trab_rut;
        }
	
	
	public function getTrab_nombres () {
            return $this->trab_nombres;
	}

	public function setTrab_nombres($trab_nombres) {
            $this->trab_nombres = $trab_nombres;
        }
	
	
	public function getFecha_solic () {
            return $this->fecha_solic;
	}

	public function setFecha_solic($fecha_solic) {
            $this->fecha_solic = $fecha_solic;
        }
	
	
	public function getFecha_solic_fmt () {
            return $this->fecha_solic_fmt;
	}

	public function setFecha_solic_fmt($fecha_solic_fmt) {
            $this->fecha_solic_fmt = $fecha_solic_fmt;
        }
	
	
	public function getCod_estado () {
            return $this->cod_estado;
	}

	public function setCod_estado($cod_estado) {
            $this->cod_estado = $cod_estado;
        }
	
	
	public function getTado_dom_dscr () {
            return $this->tado_dom_dscr;
	}

	public function setTado_dom_dscr($tado_dom_dscr) {
            $this->tado_dom_dscr = $tado_dom_dscr;
        }
	
	
	public function getObs () {
            return $this->obs;
	}

	public function setObs($obs) {
            $this->obs = $obs;
        }
	
}
