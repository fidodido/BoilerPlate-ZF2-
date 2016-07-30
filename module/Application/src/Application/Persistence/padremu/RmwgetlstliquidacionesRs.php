<?php
namespace Application\Persistence\padremu;

class RmwgetlstliquidacionesRs {

	// array.
	public $peri_codigo;	
	public $trab_codigo;	
	
	
	public function getPeri_codigo () {
            return $this->peri_codigo;
	}

	public function setPeri_codigo($peri_codigo) {
            $this->peri_codigo = $peri_codigo;
        }
	
	
	public function getTrab_codigo () {
            return $this->trab_codigo;
	}

	public function setTrab_codigo($trab_codigo) {
            $this->trab_codigo = $trab_codigo;
        }
	
}
