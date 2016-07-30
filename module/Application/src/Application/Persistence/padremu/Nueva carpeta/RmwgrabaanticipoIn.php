<?php
namespace Application\Persistence\padremu;
// parametros de entrada.
class RmwgrabaanticipoIn {

	public $p_soan_seq = null;
	public $p_trab_codigo = null;
	public $p_soan_fech_sol = null;
	public $p_soan_fech_abono = null;
	public $p_soan_monto = null;
	public $p_soan_estado = null;
	public $p_soan_obs = null;
	
	
	public function getP_soan_seq() {
            return $this->p_soan_seq;
	}

	public function setP_soan_seq($p_soan_seq){
            $this->p_soan_seq = $p_soan_seq;
	}
	public function getP_trab_codigo() {
            return $this->p_trab_codigo;
	}

	public function setP_trab_codigo($p_trab_codigo){
            $this->p_trab_codigo = $p_trab_codigo;
	}
	public function getP_soan_fech_sol() {
            return $this->p_soan_fech_sol;
	}

	public function setP_soan_fech_sol($p_soan_fech_sol){
            $this->p_soan_fech_sol = $p_soan_fech_sol;
	}
	public function getP_soan_fech_abono() {
            return $this->p_soan_fech_abono;
	}

	public function setP_soan_fech_abono($p_soan_fech_abono){
            $this->p_soan_fech_abono = $p_soan_fech_abono;
	}
	public function getP_soan_monto() {
            return $this->p_soan_monto;
	}

	public function setP_soan_monto($p_soan_monto){
            $this->p_soan_monto = $p_soan_monto;
	}
	public function getP_soan_estado() {
            return $this->p_soan_estado;
	}

	public function setP_soan_estado($p_soan_estado){
            $this->p_soan_estado = $p_soan_estado;
	}
	public function getP_soan_obs() {
            return $this->p_soan_obs;
	}

	public function setP_soan_obs($p_soan_obs){
            $this->p_soan_obs = $p_soan_obs;
	}
	
}

