<?php
namespace Application\Persistence\padremu;

class RmwgetlstdominioRs {

	// array.
	public $tado_codigo;	
	public $tado_dom_codigo;	
	public $tado_dom_dscr;	
	
	
	public function getTado_codigo () {
            return $this->tado_codigo;
	}

	public function setTado_codigo($tado_codigo) {
            $this->tado_codigo = $tado_codigo;
        }
	
	
	public function getTado_dom_codigo () {
            return $this->tado_dom_codigo;
	}

	public function setTado_dom_codigo($tado_dom_codigo) {
            $this->tado_dom_codigo = $tado_dom_codigo;
        }
	
	
	public function getTado_dom_dscr () {
            return $this->tado_dom_dscr;
	}

	public function setTado_dom_dscr($tado_dom_dscr) {
            $this->tado_dom_dscr = $tado_dom_dscr;
        }
	
}
