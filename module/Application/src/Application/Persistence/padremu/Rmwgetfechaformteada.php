<?php


namespace Application\Persistence\padremu;

// codigo generado importado.
use Application\Persistence\padremu\RmwgetfechaformteadaRs;    
use Application\Persistence\padremu\RmwgetfechaformteadaOut; 
// core.
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;
use Padcore\Persistence\Parameter;
// excepciones usadas
use Padcore\Exception\SqlException;
use Padcore\Exception\BusinessException;
use Padcore\Exception\ServiceException;

class Rmwgetfechaformteada {
    
    private $plsql;
    private $log;

    public function __construct() {
        $this->log = \Logger::getLogger(__CLASS__);
    }

    public function setProcedure($plsql) {
        $this->plsql = $plsql;
    }

    public function getProcedure() {
        return $this->plsql;
    }

    public function commit() {
        $this->plsql->commit();
    }
	
	
    public function execute($in) {
        
        $this->plsql = $this->getProcedure();
        
        // set nombre del procedimiento.
        $this->plsql->setName('Rmw_get_fecha_formteada');

        // los parametros deben ser declarados en ORDEN del PLSQL -->
	$this->plsql->declareParam(new SqlOutParameter('retorno', Parameter::VARCHAR));	     
        $this->plsql->declareParam(new SqlParameter('p_fecha', Parameter::TIMESTAMP, $in->getP_fecha()));
        $this->plsql->declareParam(new SqlParameter('p_formato', Parameter::VARCHAR, $in->getP_formato()));
		
	$this->plsql->setFunction(true);
		    
        $result = $this->plsql->execute();

        if ($result) {

            $this->evaluateResult($result, $this->plsql);
            $out = new RmwgetfechaformteadaOut();
           
            $out->setRetorno($result['retorno']);
            
        } else {
            $this->plsql->rollback();
            $e = $this->plsql->getErrors();
            $this->log->error('[COD:' . $e['code'] . '][MSG:' . $e['message'] . ']');
            throw new SqlException($e['message']);
        }

        return $out;
    }


 private function evaluateResult($result, $plsql) {

        if ($result) {

            $codigoError = $result['p_cod_err'];

            //@error inmanejable --->
            if ($codigoError < 0) {
		$plsql->rollback();
                $this->log->error('ServiceError:[COD:' . $result['p_cod_err'] . '][DESC' . $result['p_des_err'] . ']');
                throw new ServiceException($result['p_des_err'], $result['p_cod_err']);
            }

            //@error manejable ->
            else if ($codigoError > 0) {
		$plsql->rollback();
                $this->log->error('ServiceError:[COD:' . $result['p_cod_err'] . '][DESC' . $result['p_des_err'] . ']');
                throw new BusinessException($result['p_des_err'], $result['p_cod_err']);
            }
        }

        return true;
    }


}


   
