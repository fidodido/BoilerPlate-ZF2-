<?php
namespace Application\Persistence\padremu;
// parametros de entrada.
class RmwgetfechaformteadaIn {

	public $p_fecha = null;
	public $p_formato = null;
	
	
	public function getP_fecha() {
            return $this->p_fecha;
	}

	public function setP_fecha($p_fecha){
            $this->p_fecha = $p_fecha;
	}
	public function getP_formato() {
            return $this->p_formato;
	}

	public function setP_formato($p_formato){
            $this->p_formato = $p_formato;
	}
	
}

