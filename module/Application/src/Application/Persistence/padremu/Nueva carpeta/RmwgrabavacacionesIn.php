<?php
namespace Application\Persistence\padremu;
// parametros de entrada.
class RmwgrabavacacionesIn {

	public $p_sova_seq = null;
	public $p_trab_codigo = null;
	public $p_sova_tipo = null;
	public $p_sova_fech_sol = null;
	public $p_sova_fech_ini = null;
	public $p_sova_fech_ter = null;
	public $p_sova_nro_dias = null;
	public $p_sova_estado = null;
	public $p_sova_obs = null;
	
	
	public function getP_sova_seq() {
            return $this->p_sova_seq;
	}

	public function setP_sova_seq($p_sova_seq){
            $this->p_sova_seq = $p_sova_seq;
	}
	public function getP_trab_codigo() {
            return $this->p_trab_codigo;
	}

	public function setP_trab_codigo($p_trab_codigo){
            $this->p_trab_codigo = $p_trab_codigo;
	}
	public function getP_sova_tipo() {
            return $this->p_sova_tipo;
	}

	public function setP_sova_tipo($p_sova_tipo){
            $this->p_sova_tipo = $p_sova_tipo;
	}
	public function getP_sova_fech_sol() {
            return $this->p_sova_fech_sol;
	}

	public function setP_sova_fech_sol($p_sova_fech_sol){
            $this->p_sova_fech_sol = $p_sova_fech_sol;
	}
	public function getP_sova_fech_ini() {
            return $this->p_sova_fech_ini;
	}

	public function setP_sova_fech_ini($p_sova_fech_ini){
            $this->p_sova_fech_ini = $p_sova_fech_ini;
	}
	public function getP_sova_fech_ter() {
            return $this->p_sova_fech_ter;
	}

	public function setP_sova_fech_ter($p_sova_fech_ter){
            $this->p_sova_fech_ter = $p_sova_fech_ter;
	}
	public function getP_sova_nro_dias() {
            return $this->p_sova_nro_dias;
	}

	public function setP_sova_nro_dias($p_sova_nro_dias){
            $this->p_sova_nro_dias = $p_sova_nro_dias;
	}
	public function getP_sova_estado() {
            return $this->p_sova_estado;
	}

	public function setP_sova_estado($p_sova_estado){
            $this->p_sova_estado = $p_sova_estado;
	}
	public function getP_sova_obs() {
            return $this->p_sova_obs;
	}

	public function setP_sova_obs($p_sova_obs){
            $this->p_sova_obs = $p_sova_obs;
	}
	
}

