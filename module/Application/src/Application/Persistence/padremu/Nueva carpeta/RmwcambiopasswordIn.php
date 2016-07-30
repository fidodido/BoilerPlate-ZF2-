<?php
namespace Application\Persistence\padremu;
// parametros de entrada.
class RmwcambiopasswordIn {

	public $p_pass_anterior = null;
	public $p_pass_nueva1 = null;
	public $p_pass_nueva2 = null;
	
	
	public function getP_pass_anterior() {
            return $this->p_pass_anterior;
	}

	public function setP_pass_anterior($p_pass_anterior){
            $this->p_pass_anterior = $p_pass_anterior;
	}
	public function getP_pass_nueva1() {
            return $this->p_pass_nueva1;
	}

	public function setP_pass_nueva1($p_pass_nueva1){
            $this->p_pass_nueva1 = $p_pass_nueva1;
	}
	public function getP_pass_nueva2() {
            return $this->p_pass_nueva2;
	}

	public function setP_pass_nueva2($p_pass_nueva2){
            $this->p_pass_nueva2 = $p_pass_nueva2;
	}
	
}

