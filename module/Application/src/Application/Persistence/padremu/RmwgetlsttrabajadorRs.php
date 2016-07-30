<?php
namespace Application\Persistence\padremu;

class RmwgetlsttrabajadorRs {

	// array.
	public $trab_codigo;	
	public $trab_rut;	
	public $trab_nombres;	
	
	
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
	
}
