<?php

namespace Application\Persistence\padremu;

class RmwgetlstliquidebitoOut {

	public $retorno;
	public $p_tot_reg;
	public $p_cod_err;
	public $p_des_err;
	
	
	public function getRetorno () {
		return $this->retorno;
	}
	
	public function setRetorno($value) {
        $this->retorno = $value;
    }	

	
	
	
	
	public function getP_tot_reg () {
		return $this->p_tot_reg;
	}
	
	public function setP_tot_reg($value) {
        $this->p_tot_reg = $value;
    }	

	
	public function getP_cod_err () {
		return $this->p_cod_err;
	}
	
	public function setP_cod_err($value) {
        $this->p_cod_err = $value;
    }	

	
	public function getP_des_err () {
		return $this->p_des_err;
	}
	
	public function setP_des_err($value) {
        $this->p_des_err = $value;
    }	

	
	
	
}
