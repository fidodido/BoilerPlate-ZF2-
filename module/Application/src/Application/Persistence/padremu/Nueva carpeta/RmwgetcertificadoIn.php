<?php
namespace Application\Persistence\padremu;
// parametros de entrada.
class RmwgetcertificadoIn {

	public $p_trab_codigo = null;
	public $p_tipo_cert = null;
	public $p_seq_solic = null;
	
	
	public function getP_trab_codigo() {
            return $this->p_trab_codigo;
	}

	public function setP_trab_codigo($p_trab_codigo){
            $this->p_trab_codigo = $p_trab_codigo;
	}
	public function getP_tipo_cert() {
            return $this->p_tipo_cert;
	}

	public function setP_tipo_cert($p_tipo_cert){
            $this->p_tipo_cert = $p_tipo_cert;
	}
	public function getP_seq_solic() {
            return $this->p_seq_solic;
	}

	public function setP_seq_solic($p_seq_solic){
            $this->p_seq_solic = $p_seq_solic;
	}
	
}

