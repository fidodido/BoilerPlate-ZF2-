<?php
namespace Application\Persistence\padremu;

class RmwgetlstliquihaberesRs {

	// array.
	public $peri_codigo;	
	public $peri_dscr;	
	public $trab_codigo;	
	public $trab_rut;	
	public $trab_nombre;	
	public $tado_dom_dscr;	
	public $valor;	
	public $liqu_variable;	
	public $orden;	
	
	
	public function getPeri_codigo () {
            return $this->peri_codigo;
	}

	public function setPeri_codigo($peri_codigo) {
            $this->peri_codigo = $peri_codigo;
        }
	
	
	public function getPeri_dscr () {
            return $this->peri_dscr;
	}

	public function setPeri_dscr($peri_dscr) {
            $this->peri_dscr = $peri_dscr;
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
	
	
	public function getTrab_nombre () {
            return $this->trab_nombre;
	}

	public function setTrab_nombre($trab_nombre) {
            $this->trab_nombre = $trab_nombre;
        }
	
	
	public function getTado_dom_dscr () {
            return $this->tado_dom_dscr;
	}

	public function setTado_dom_dscr($tado_dom_dscr) {
            $this->tado_dom_dscr = $tado_dom_dscr;
        }
	
	
	public function getValor () {
            return $this->valor;
	}

	public function setValor($valor) {
            $this->valor = $valor;
        }
	
	
	public function getLiqu_variable () {
            return $this->liqu_variable;
	}

	public function setLiqu_variable($liqu_variable) {
            $this->liqu_variable = $liqu_variable;
        }
	
	
	public function getOrden () {
            return $this->orden;
	}

	public function setOrden($orden) {
            $this->orden = $orden;
        }
	
}
