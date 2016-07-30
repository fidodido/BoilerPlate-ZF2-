<?php


namespace Application\Persistence\padremu;

// codigo generado importado.
use Application\Persistence\padremu\RmwgrabaanticipoRs;    
use Application\Persistence\padremu\RmwgrabaanticipoOut; 
// core.
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;
use Padcore\Persistence\Parameter;
// excepciones usadas
use Padcore\Exception\SqlException;
use Padcore\Exception\BusinessException;
use Padcore\Exception\ServiceException;

class Rmwgrabaanticipo {
    
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
        $this->plsql->setName('Rmw_graba_anticipo');

        // los parametros deben ser declarados en ORDEN del PLSQL -->
        $this->plsql->declareParam(new SqlParameter('p_soan_seq', Parameter::NUMERIC, $in->getP_soan_seq()));
        $this->plsql->declareParam(new SqlParameter('p_trab_codigo', Parameter::NUMERIC, $in->getP_trab_codigo()));
        $this->plsql->declareParam(new SqlParameter('p_soan_fech_sol', Parameter::TIMESTAMP, $in->getP_soan_fech_sol()));
        $this->plsql->declareParam(new SqlParameter('p_soan_fech_abono', Parameter::TIMESTAMP, $in->getP_soan_fech_abono()));
        $this->plsql->declareParam(new SqlParameter('p_soan_monto', Parameter::NUMERIC, $in->getP_soan_monto()));
        $this->plsql->declareParam(new SqlParameter('p_soan_estado', Parameter::VARCHAR, $in->getP_soan_estado()));
        $this->plsql->declareParam(new SqlParameter('p_soan_obs', Parameter::VARCHAR, $in->getP_soan_obs()));
	$this->plsql->declareParam(new SqlOutParameter('p_soan_seq_out', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_cod_err', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_des_err', Parameter::VARCHAR));	     
		
	$this->plsql->setFunction(false);
		    
        $result = $this->plsql->execute();

        if ($result) {

            $this->evaluateResult($result, $this->plsql);
            $out = new RmwgrabaanticipoOut();
           
            $out->setP_soan_seq_out($result['p_soan_seq_out']);
            $out->setP_cod_err($result['p_cod_err']);
            $out->setP_des_err($result['p_des_err']);
            
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


   
