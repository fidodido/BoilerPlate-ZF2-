<?php


namespace Application\Persistence\padremu;

// codigo generado importado.
use Application\Persistence\padremu\RmwgetlstvacacionesRs;    
use Application\Persistence\padremu\RmwgetlstvacacionesOut; 
// core.
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;
use Padcore\Persistence\Parameter;
// excepciones usadas
use Padcore\Exception\SqlException;
use Padcore\Exception\BusinessException;
use Padcore\Exception\ServiceException;

class Rmwgetlstvacaciones {
    
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
        $this->plsql->setName('Rmw_get_lst_vacaciones');

        // los parametros deben ser declarados en ORDEN del PLSQL -->
	$this->plsql->declareParam(new SqlOutParameter('retorno', Parameter::CURSOR));	     
        $this->plsql->declareParam(new SqlParameter('p_count', Parameter::NUMERIC, $in->getP_count()));
        $this->plsql->declareParam(new SqlParameter('p_offset', Parameter::NUMERIC, $in->getP_offset()));
        $this->plsql->declareParam(new SqlParameter('p_numreg', Parameter::NUMERIC, $in->getP_numreg()));
	$this->plsql->declareParam(new SqlOutParameter('p_tot_reg', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_cod_err', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_des_err', Parameter::VARCHAR));	     
        $this->plsql->declareParam(new SqlParameter('p_ord_by', Parameter::VARCHAR, $in->getP_ord_by()));
        $this->plsql->declareParam(new SqlParameter('p_sova_seq', Parameter::NUMERIC, $in->getP_sova_seq()));
		
	$this->plsql->setFunction(true);
		    
        $result = $this->plsql->execute();

        if ($result) {

            $this->evaluateResult($result, $this->plsql);
            $out = new RmwgetlstvacacionesOut();
           
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

            $rs = new RmwgetlstvacacionesRs();
            if (isset($v[strtoupper('sova_seq')])) {
                $rs->setSova_seq($v[strtoupper('sova_seq')]);
            }
            if (isset($v[strtoupper('trab_codigo')])) {
                $rs->setTrab_codigo($v[strtoupper('trab_codigo')]);
            }
            if (isset($v[strtoupper('trab_rut')])) {
                $rs->setTrab_rut($v[strtoupper('trab_rut')]);
            }
            if (isset($v[strtoupper('trab_nombre')])) {
                $rs->setTrab_nombre($v[strtoupper('trab_nombre')]);
            }
            if (isset($v[strtoupper('sova_tipo')])) {
                $rs->setSova_tipo($v[strtoupper('sova_tipo')]);
            }
            if (isset($v[strtoupper('sova_fech_sol')])) {
                $rs->setSova_fech_sol($v[strtoupper('sova_fech_sol')]);
            }
            if (isset($v[strtoupper('sova_fech_sol_fmt')])) {
                $rs->setSova_fech_sol_fmt($v[strtoupper('sova_fech_sol_fmt')]);
            }
            if (isset($v[strtoupper('sova_fech_ini')])) {
                $rs->setSova_fech_ini($v[strtoupper('sova_fech_ini')]);
            }
            if (isset($v[strtoupper('sova_fech_ini_fmt')])) {
                $rs->setSova_fech_ini_fmt($v[strtoupper('sova_fech_ini_fmt')]);
            }
            if (isset($v[strtoupper('sova_fech_ter')])) {
                $rs->setSova_fech_ter($v[strtoupper('sova_fech_ter')]);
            }
            if (isset($v[strtoupper('sova_fech_ter_fmt')])) {
                $rs->setSova_fech_ter_fmt($v[strtoupper('sova_fech_ter_fmt')]);
            }
            if (isset($v[strtoupper('sova_nro_dias')])) {
                $rs->setSova_nro_dias($v[strtoupper('sova_nro_dias')]);
            }
            if (isset($v[strtoupper('sova_estado')])) {
                $rs->setSova_estado($v[strtoupper('sova_estado')]);
            }
            if (isset($v[strtoupper('esta_desc')])) {
                $rs->setEsta_desc($v[strtoupper('esta_desc')]);
            }
            if (isset($v[strtoupper('sova_obs')])) {
                $rs->setSova_obs($v[strtoupper('sova_obs')]);
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


   
