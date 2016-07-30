<?php


namespace Application\Persistence\padremu;

// codigo generado importado.
use Application\Persistence\padremu\RmwgetlstfichaRs;    
use Application\Persistence\padremu\RmwgetlstfichaOut; 
// core.
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;
use Padcore\Persistence\Parameter;
// excepciones usadas
use Padcore\Exception\SqlException;
use Padcore\Exception\BusinessException;
use Padcore\Exception\ServiceException;

class Rmwgetlstficha {
    
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
        $this->plsql->setName('Rmw_get_lst_ficha');

        // los parametros deben ser declarados en ORDEN del PLSQL -->
	$this->plsql->declareParam(new SqlOutParameter('retorno', Parameter::CURSOR));	     
        $this->plsql->declareParam(new SqlParameter('p_count', Parameter::NUMERIC, $in->getP_count()));
        $this->plsql->declareParam(new SqlParameter('p_offset', Parameter::NUMERIC, $in->getP_offset()));
        $this->plsql->declareParam(new SqlParameter('p_numreg', Parameter::NUMERIC, $in->getP_numreg()));
	$this->plsql->declareParam(new SqlOutParameter('p_tot_reg', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_cod_err', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_des_err', Parameter::VARCHAR));	     
        $this->plsql->declareParam(new SqlParameter('p_ord_by', Parameter::VARCHAR, $in->getP_ord_by()));
        $this->plsql->declareParam(new SqlParameter('p_trab_codigo', Parameter::NUMERIC, $in->getP_trab_codigo()));
		
	$this->plsql->setFunction(true);
		    
        $result = $this->plsql->execute();

        if ($result) {

            $this->evaluateResult($result, $this->plsql);
            $out = new RmwgetlstfichaOut();
           
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

            $rs = new RmwgetlstfichaRs();
            if (isset($v[strtoupper('trab_codigo')])) {
                $rs->setTrab_codigo($v[strtoupper('trab_codigo')]);
            }
            if (isset($v[strtoupper('trab_rut')])) {
                $rs->setTrab_rut($v[strtoupper('trab_rut')]);
            }
            if (isset($v[strtoupper('trab_nombres')])) {
                $rs->setTrab_nombres($v[strtoupper('trab_nombres')]);
            }
            if (isset($v[strtoupper('trab_apepat')])) {
                $rs->setTrab_apepat($v[strtoupper('trab_apepat')]);
            }
            if (isset($v[strtoupper('trab_apemat')])) {
                $rs->setTrab_apemat($v[strtoupper('trab_apemat')]);
            }
            if (isset($v[strtoupper('trab_fecnac')])) {
                $rs->setTrab_fecnac($v[strtoupper('trab_fecnac')]);
            }
            if (isset($v[strtoupper('trab_fecingreso')])) {
                $rs->setTrab_fecingreso($v[strtoupper('trab_fecingreso')]);
            }
            if (isset($v[strtoupper('trab_sexo')])) {
                $rs->setTrab_sexo($v[strtoupper('trab_sexo')]);
            }
            if (isset($v[strtoupper('trab_estacivil')])) {
                $rs->setTrab_estacivil($v[strtoupper('trab_estacivil')]);
            }
            if (isset($v[strtoupper('trab_direccion')])) {
                $rs->setTrab_direccion($v[strtoupper('trab_direccion')]);
            }
            if (isset($v[strtoupper('trab_ciudad')])) {
                $rs->setTrab_ciudad($v[strtoupper('trab_ciudad')]);
            }
            if (isset($v[strtoupper('trab_telefono')])) {
                $rs->setTrab_telefono($v[strtoupper('trab_telefono')]);
            }
            if (isset($v[strtoupper('trab_email')])) {
                $rs->setTrab_email($v[strtoupper('trab_email')]);
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
            if (isset($v[strtoupper('nro_cta')])) {
                $rs->setNro_cta($v[strtoupper('nro_cta')]);
            }
            if (isset($v[strtoupper('detr_nro_cargas')])) {
                $rs->setDetr_nro_cargas($v[strtoupper('detr_nro_cargas')]);
            }
            if (isset($v[strtoupper('detr_segurocesac')])) {
                $rs->setDetr_segurocesac($v[strtoupper('detr_segurocesac')]);
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


   
