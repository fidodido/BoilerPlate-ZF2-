<?php
namespace Application\Persistence\padremu;
// parametros de entrada.
class RmwgetlstliquiencIn {

	public $p_count = null;
	public $p_offset = null;
	public $p_numreg = null;
	public $p_ord_by = null;
	public $p_peri_codigo = null;
	public $p_trab_codigo = null;
	
	
	public function getP_count() {
            return $this->p_count;
	}

	public function setP_count($p_count){
            $this->p_count = $p_count;
	}
	public function getP_offset() {
            return $this->p_offset;
	}

	public function setP_offset($p_offset){
            $this->p_offset = $p_offset;
	}
	public function getP_numreg() {
            return $this->p_numreg;
	}

	public function setP_numreg($p_numreg){
            $this->p_numreg = $p_numreg;
	}
	public function getP_ord_by() {
            return $this->p_ord_by;
	}

	public function setP_ord_by($p_ord_by){
            $this->p_ord_by = $p_ord_by;
	}
	public function getP_peri_codigo() {
            return $this->p_peri_codigo;
	}

	public function setP_peri_codigo($p_peri_codigo){
            $this->p_peri_codigo = $p_peri_codigo;
	}
	public function getP_trab_codigo() {
            return $this->p_trab_codigo;
	}

	public function setP_trab_codigo($p_trab_codigo){
            $this->p_trab_codigo = $p_trab_codigo;
	}
	
}

