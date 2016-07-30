<?php

namespace Application\Persistence\padremu;

class RmwcambiopasswordOut {

	public $p_cod_err;
	public $p_des_err;
	
	
	
	
	
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
