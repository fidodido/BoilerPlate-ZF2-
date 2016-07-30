<?php


namespace Application\Persistence\padremu;

// codigo generado importado.
use Application\Persistence\padremu\RmwgrabavacacionesRs;    
use Application\Persistence\padremu\RmwgrabavacacionesOut; 
// core.
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;
use Padcore\Persistence\Parameter;
// excepciones usadas
use Padcore\Exception\SqlException;
use Padcore\Exception\BusinessException;
use Padcore\Exception\ServiceException;

class Rmwgrabavacaciones {
    
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
        $this->plsql->setName('Rmw_graba_vacaciones');

        // los parametros deben ser declarados en ORDEN del PLSQL -->
        $this->plsql->declareParam(new SqlParameter('p_sova_seq', Parameter::NUMERIC, $in->getP_sova_seq()));
        $this->plsql->declareParam(new SqlParameter('p_trab_codigo', Parameter::NUMERIC, $in->getP_trab_codigo()));
        $this->plsql->declareParam(new SqlParameter('p_sova_tipo', Parameter::VARCHAR, $in->getP_sova_tipo()));
        $this->plsql->declareParam(new SqlParameter('p_sova_fech_sol', Parameter::TIMESTAMP, $in->getP_sova_fech_sol()));
        $this->plsql->declareParam(new SqlParameter('p_sova_fech_ini', Parameter::TIMESTAMP, $in->getP_sova_fech_ini()));
        $this->plsql->declareParam(new SqlParameter('p_sova_fech_ter', Parameter::TIMESTAMP, $in->getP_sova_fech_ter()));
        $this->plsql->declareParam(new SqlParameter('p_sova_nro_dias', Parameter::NUMERIC, $in->getP_sova_nro_dias()));
        $this->plsql->declareParam(new SqlParameter('p_sova_estado', Parameter::VARCHAR, $in->getP_sova_estado()));
        $this->plsql->declareParam(new SqlParameter('p_sova_obs', Parameter::VARCHAR, $in->getP_sova_obs()));
	$this->plsql->declareParam(new SqlOutParameter('p_sova_seq_out', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_cod_err', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_des_err', Parameter::VARCHAR));	     
		
	$this->plsql->setFunction(false);
		    
        $result = $this->plsql->execute();

        if ($result) {

            $this->evaluateResult($result, $this->plsql);
            $out = new RmwgrabavacacionesOut();
           
            $out->setP_sova_seq_out($result['p_sova_seq_out']);
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


   
