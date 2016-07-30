<?php


namespace Application\Persistence\padremu;

// codigo generado importado.
use Application\Persistence\padremu\RmwgetlsttrabuserRs;    
use Application\Persistence\padremu\RmwgetlsttrabuserOut; 
// core.
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;
use Padcore\Persistence\Parameter;
// excepciones usadas
use Padcore\Exception\SqlException;
use Padcore\Exception\BusinessException;
use Padcore\Exception\ServiceException;

class Rmwgetlsttrabuser {
    
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
        $this->plsql->setName('Rmw_get_lst_trab_user');

        // los parametros deben ser declarados en ORDEN del PLSQL -->
	$this->plsql->declareParam(new SqlOutParameter('retorno', Parameter::CURSOR));	     
        $this->plsql->declareParam(new SqlParameter('p_count', Parameter::NUMERIC, $in->getP_count()));
        $this->plsql->declareParam(new SqlParameter('p_offset', Parameter::NUMERIC, $in->getP_offset()));
        $this->plsql->declareParam(new SqlParameter('p_numreg', Parameter::NUMERIC, $in->getP_numreg()));
	$this->plsql->declareParam(new SqlOutParameter('p_tot_reg', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_cod_err', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_des_err', Parameter::VARCHAR));	     
        $this->plsql->declareParam(new SqlParameter('p_ord_by', Parameter::VARCHAR, $in->getP_ord_by()));
		
	$this->plsql->setFunction(true);
		    
        $result = $this->plsql->execute();

        if ($result) {

            $this->evaluateResult($result, $this->plsql);
            $out = new RmwgetlsttrabuserOut();
           
            $out->setRetorno($this->mapRs($result['retorno']));
            $out->setP_tot_reg($result['p_tot_reg']);
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

    private function mapRs($array) {

        $rsList = array();
		
        foreach ($array as $key => $v) {

            $rs = new RmwgetlsttrabuserRs();
            if (isset($v[strtoupper('trab_codigo')])) {
                $rs->setTrab_codigo($v[strtoupper('trab_codigo')]);
            }
            if (isset($v[strtoupper('trab_rut')])) {
                $rs->setTrab_rut($v[strtoupper('trab_rut')]);
            }
            if (isset($v[strtoupper('trab_nombres')])) {
                $rs->setTrab_nombres($v[strtoupper('trab_nombres')]);
            }
            if (isset($v[strtoupper('trab_role')])) {
                $rs->setTrab_role($v[strtoupper('trab_role')]);
            }
            $rsList[] = $rs;
        }

        return $rsList;
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


   
