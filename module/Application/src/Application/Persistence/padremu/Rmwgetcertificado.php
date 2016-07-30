<?php


namespace Application\Persistence\padremu;

// codigo generado importado.
use Application\Persistence\padremu\RmwgetcertificadoRs;    
use Application\Persistence\padremu\RmwgetcertificadoOut; 
// core.
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;
use Padcore\Persistence\Parameter;
// excepciones usadas
use Padcore\Exception\SqlException;
use Padcore\Exception\BusinessException;
use Padcore\Exception\ServiceException;

class Rmwgetcertificado {
    
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
        $this->plsql->setName('Rmw_get_certificado');

        // los parametros deben ser declarados en ORDEN del PLSQL -->
        $this->plsql->declareParam(new SqlParameter('p_trab_codigo', Parameter::NUMERIC, $in->getP_trab_codigo()));
        $this->plsql->declareParam(new SqlParameter('p_tipo_cert', Parameter::VARCHAR, $in->getP_tipo_cert()));
        $this->plsql->declareParam(new SqlParameter('p_seq_solic', Parameter::NUMERIC, $in->getP_seq_solic()));
	$this->plsql->declareParam(new SqlOutParameter('p_titulo', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto1', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto2', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto3', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto4', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto5', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto6', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto7', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto8', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto9', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto10', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto11', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto12', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto13', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_texto14', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_firma1', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_firma2', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_firma3', Parameter::VARCHAR));	     
	$this->plsql->declareParam(new SqlOutParameter('p_cod_err', Parameter::NUMERIC));	     
	$this->plsql->declareParam(new SqlOutParameter('p_des_err', Parameter::VARCHAR));	     
		
	$this->plsql->setFunction(false);
		    
        $result = $this->plsql->execute();

        if ($result) {

            $this->evaluateResult($result, $this->plsql);
            $out = new RmwgetcertificadoOut();
           
            $out->setP_titulo($result['p_titulo']);
            $out->setP_texto1($result['p_texto1']);
            $out->setP_texto2($result['p_texto2']);
            $out->setP_texto3($result['p_texto3']);
            $out->setP_texto4($result['p_texto4']);
            $out->setP_texto5($result['p_texto5']);
            $out->setP_texto6($result['p_texto6']);
            $out->setP_texto7($result['p_texto7']);
            $out->setP_texto8($result['p_texto8']);
            $out->setP_texto9($result['p_texto9']);
            $out->setP_texto10($result['p_texto10']);
            $out->setP_texto11($result['p_texto11']);
            $out->setP_texto12($result['p_texto12']);
            $out->setP_texto13($result['p_texto13']);
            $out->setP_texto14($result['p_texto14']);
            $out->setP_firma1($result['p_firma1']);
            $out->setP_firma2($result['p_firma2']);
            $out->setP_firma3($result['p_firma3']);
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


   
