<?php


namespace Application\Persistence\padremu;

// codigo generado importado.
use Application\Persistence\padremu\RmwgetlstliquiencRs;    
use Application\Persistence\padremu\RmwgetlstliquiencOut; 
// core.
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;
use Padcore\Persistence\Parameter;
// excepciones usadas
use Padcore\Exception\SqlException;
use Padcore\Exception\BusinessException;
use Padcore\Exception\ServiceException;

class Rmwgetlstliquienc {
    
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
        $this->plsql->setName('Rmw_get_lst_liqui_enc');

        // los parametros deben ser declarados en ORDEN del PLSQL -->
	$this->plsql->declareParam(new SqlOutParameter('retorno', Parameter::CURSOR));	     
        $this->plsql->declareParam(new SqlParameter('p_count', Parameter::NUMERIC, $in->getP_count()));
        $this->plsql->declareParam(new SqlParameter('p_offset', Parameter::NUMERIC, $in->getP_offset()));
        $this->plsql->declareParam(new SqlParameter('p_numreg', Parameter::NUMERIC, $in->getP_numreg()));
	$this->plsql->declareParam(new SqlOutParameter('p_tot_reg', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_cod_err', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_des_err', Parameter::VARCHAR));	     
        $this->plsql->declareParam(new SqlParameter('p_ord_by', Parameter::VARCHAR, $in->getP_ord_by()));
        $this->plsql->declareParam(new SqlParameter('p_peri_codigo', Parameter::VARCHAR, $in->getP_peri_codigo()));
        $this->plsql->declareParam(new SqlParameter('p_trab_codigo', Parameter::NUMERIC, $in->getP_trab_codigo()));
		
	$this->plsql->setFunction(true);
		    
        $result = $this->plsql->execute();

        if ($result) {

            $this->evaluateResult($result, $this->plsql);
            $out = new RmwgetlstliquiencOut();
           
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

            $rs = new RmwgetlstliquiencRs();
            if (isset($v[strtoupper('peri_codigo')])) {
                $rs->setPeri_codigo($v[strtoupper('peri_codigo')]);
            }
            if (isset($v[strtoupper('peri_dscr')])) {
                $rs->setPeri_dscr($v[strtoupper('peri_dscr')]);
            }
            if (isset($v[strtoupper('empr_codigo')])) {
                $rs->setEmpr_codigo($v[strtoupper('empr_codigo')]);
            }
            if (isset($v[strtoupper('empr_nombre')])) {
                $rs->setEmpr_nombre($v[strtoupper('empr_nombre')]);
            }
            if (isset($v[strtoupper('empr_rut')])) {
                $rs->setEmpr_rut($v[strtoupper('empr_rut')]);
            }
            if (isset($v[strtoupper('empr_direc')])) {
                $rs->setEmpr_direc($v[strtoupper('empr_direc')]);
            }
            if (isset($v[strtoupper('empr_ciud')])) {
                $rs->setEmpr_ciud($v[strtoupper('empr_ciud')]);
            }
            if (isset($v[strtoupper('trab_codigo')])) {
                $rs->setTrab_codigo($v[strtoupper('trab_codigo')]);
            }
            if (isset($v[strtoupper('trab_rut')])) {
                $rs->setTrab_rut($v[strtoupper('trab_rut')]);
            }
            if (isset($v[strtoupper('nombre')])) {
                $rs->setNombre($v[strtoupper('nombre')]);
            }
            if (isset($v[strtoupper('trab_fecingreso')])) {
                $rs->setTrab_fecingreso($v[strtoupper('trab_fecingreso')]);
            }
            if (isset($v[strtoupper('ccto_codigo')])) {
                $rs->setCcto_codigo($v[strtoupper('ccto_codigo')]);
            }
            if (isset($v[strtoupper('detr_cargo')])) {
                $rs->setDetr_cargo($v[strtoupper('detr_cargo')]);
            }
            if (isset($v[strtoupper('afp')])) {
                $rs->setAfp($v[strtoupper('afp')]);
            }
            if (isset($v[strtoupper('isapre')])) {
                $rs->setIsapre($v[strtoupper('isapre')]);
            }
            if (isset($v[strtoupper('banco')])) {
                $rs->setBanco($v[strtoupper('banco')]);
            }
            if (isset($v[strtoupper('liqu_liquido')])) {
                $rs->setLiqu_liquido($v[strtoupper('liqu_liquido')]);
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


   