<?php

namespace Repository\Entity;

// entities
use Repository\Entity\Repository;
use Application\Model\Entity\Tipo;
use Application\Model\Entity\Estado;
use Application\Model\Entity\Solicitud;
use Application\Model\Entity\Cumpleanos;
use Application\Model\Entity\Vacaciones;
use Application\Model\Entity\Anticipo;
use Application\Model\Entity\Debito;
use Application\Model\Entity\Haberes;
use Application\Model\Entity\Liquidacion;
use Auth\Model\Identity;
// plsqls
use Application\Persistence\padremu\RmwgrabaanticipoIn;
use Application\Persistence\padremu\RmwgetlstanticiposIn;
use Application\Persistence\padremu\RmwgetcertificadoIn;
use Application\Persistence\padremu\RmwgetlstfichaIn;
use Application\Persistence\padremu\RmwgrabavacacionesIn;
use Application\Persistence\padremu\RmwgetlstvacacionesIn;
use Application\Persistence\padremu\RmwgetlsttrabuserIn;
use Application\Persistence\padremu\RmwgetlstliquidebitoIn;
use Application\Persistence\padremu\RmwgetlstliquiencIn;
use Application\Persistence\padremu\RmwgetlstliquihaberesIn;
use Application\Persistence\padremu\RmwgetlstliquidacionesIn;
use Application\Persistence\padremu\RmwgetlstcumpleanosIn;
use Application\Persistence\padremu\RmwgetlstsolicitudesIn;
use Application\Persistence\padremu\RmwcambiopasswordIn;

class OracleRepository extends Repository {

    public function getCertificado($p_seq_solic, $p_tipo_cert) {
        $in = new RmwgetcertificadoIn();
        $in->setP_tipo_cert($p_tipo_cert);
        $in->setP_seq_solic($p_seq_solic);
        $in->setP_trab_codigo($this->getUser()->getId());
        $plsql = $this->getOracleServices()->getRmwgetcertificado();
        $out = $plsql->execute($in);
        return $out;
    }

    public function getFicha() {
        $in = new RmwgetlstfichaIn();
        $in->setP_count(null);
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);
        $in->setP_trab_codigo($this->getUser()->getId());
        $plsql = $this->getOracleServices()->getRmwgetlstficha();
        $out = $plsql->execute($in);
        return $out;
    }

    public function findSolicitudAnticipos($id) {

        $in = new RmwgetlstanticiposIn();

        $in->setP_soan_seq($id);
        $in->setP_count(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);

        $plsql = $this->getOracleServices()->getRmwgetlstanticipos();
        $out = $plsql->execute($in);

        $cursor = $out->getRetorno();
        $row = $cursor[0];

        $anticipo = new Anticipo();
        $anticipo->setEstado(new \Application\Model\Entity\Estado($row->soan_estado, $row->esta_desc));
        $anticipo->setFechaAbono($row->soan_fech_abono_fmt);
        $anticipo->setFechaIngreso($row->soan_fech_sol_fmt);
        $anticipo->setMonto($row->soan_monto);
        $anticipo->setObservaciones($row->soan_obs);
        $anticipo->setIdSolicitud($row->soan_seq);
        $anticipo->setTipo(new Tipo(Solicitud::TIPO_ANTICIPO));

        return $anticipo;
    }

    public function saveSolicitudAnticipo(Anticipo $anticipo) {

        $in = new RmwgrabaanticipoIn();

        $in->setP_soan_estado($anticipo->getEstado()->getCod());
        $in->setP_soan_fech_sol($anticipo->getFechaIngreso());
        $in->setP_soan_fech_abono($anticipo->getFechaAbono());
        $in->setP_soan_monto($anticipo->getMonto());
        $in->setP_soan_obs($anticipo->getObservaciones());
        $in->setP_soan_seq($anticipo->getIdSolicitud());
        $in->setP_trab_codigo($this->getUser()->getId());

        $plsql = $this->getOracleServices()->getRmwgrabaanticipo();
        $out = $plsql->execute($in);

        $plsql->commit();

        $id = $out->getP_soan_seq_out();
        return $id;
    }

    public function saveSolicitudVacaciones(Vacaciones $vacaciones) {

        $in = new RmwgrabavacacionesIn();

        $in->setP_sova_estado($vacaciones->getEstado()->getCod());
        $in->setP_sova_fech_sol($vacaciones->getFechaIngreso());
        $in->setP_sova_fech_ini($vacaciones->getFechaInicio());
        $in->setP_sova_fech_ter($vacaciones->getFechaTermino());
        $in->setP_sova_nro_dias($vacaciones->getDiasHabiles());
        $in->setP_sova_obs($vacaciones->getObservaciones());
        $in->setP_sova_seq($vacaciones->getIdSolicitud());
        $in->setP_sova_tipo($vacaciones->getTipo()->getCodigo());
        $in->setP_trab_codigo($this->getUser()->getId());


        $plsql = $this->getOracleServices()->getRmwgrabavacaciones();
        $out = $plsql->execute($in);

        $plsql->commit();

        $id = $out = $out->getP_sova_seq_out();
        return $id;
    }

    public function findSolicitudVacaciones($id) {

        $in = new RmwgetlstvacacionesIn();

        $in->setP_sova_seq($id);
        $in->setP_count(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);

        $plsql = $this->getOracleServices()->getRmwgetlstvacaciones();
        $out = $plsql->execute($in);

        $cursor = $out->getRetorno();
        $row = $cursor[0];

        $vacaciones = new Vacaciones();
        $vacaciones->setIdSolicitud($row->sova_seq);
        $vacaciones->setDiasHabiles($row->sova_nro_dias);
        $vacaciones->setFechaIngreso($row->sova_fech_sol_fmt);
        $vacaciones->setFechaInicio($row->sova_fech_ini_fmt);
        $vacaciones->setFechaTermino($row->sova_fech_ter_fmt);
        $vacaciones->setObservaciones($row->sova_obs);
        $vacaciones->setEstado(new Estado($row->sova_estado, $row->esta_desc));
        $vacaciones->setTipo(new Tipo(Solicitud::TIPO_VACACIONES));

        return $vacaciones;
    }

    public function findNavigationByIdentity() {

        return array(
            array(
                'label' => 'Deshboard',
                'uri' => null,
                'type' => 'MVC',
                'controller' => 'index',
                'action' => 'index',
                'route' => 'application/default',
                'id' => 1,
                'icon' => 'fa fa-dashboard',
                'pages' => array()
            ),
            array(
                'label' => 'Mis Solicitudes',
                'uri' => null,
                'type' => 'MVC',
                'controller' => 'solicitudes',
                'action' => 'mis-solicitudes',
                'route' => 'application/default',
                'id' => 8,
                'icon' => 'fa fa-child',
                'pages' => array()
            ),
            array(
                'label' => 'Nueva Solicitud',
                'uri' => '#',
                'type' => 'URI',
                'controller' => null,
                'action' => null,
                'route' => null,
                'id' => 3,
                'icon' => 'fa fa-plus-square',
                'pages' => array(
                    array(
                        'label' => 'Vacaciones',
                        'uri' => '#',
                        'type' => 'MVC',
                        'controller' => 'vacaciones',
                        'action' => 'agregar',
                        'route' => 'application/default',
                        'id' => 4,
                        'icon' => null
                    ), array(
                        'label' => 'Anticipo',
                        'uri' => '#',
                        'type' => 'MVC',
                        'controller' => 'anticipos',
                        'action' => 'agregar',
                        'route' => 'application/default',
                        'id' => 5,
                        'icon' => null
                    )
                )
            ),
            array(
                'label' => 'Mis Liquidaciones',
                'uri' => null,
                'type' => 'MVC',
                'controller' => 'liquidaciones',
                'action' => 'index',
                'route' => 'application/default',
                'id' => 7,
                'icon' => 'fa fa-check-square',
                'pages' => array()
            ),
            array(
                'label' => 'Mi Perfil',
                'uri' => null,
                'type' => 'MVC',
                'controller' => 'usuarios',
                'action' => 'perfil',
                'route' => 'application/default',
                'id' => 2,
                'icon' => 'fa fa-user',
                'pages' => array()
            ),
            array(
                'label' => 'Imprimir Certificados',
                'uri' => null,
                'type' => 'MVC',
                'controller' => 'certificados',
                'action' => 'index',
                'route' => 'application/default',
                'id' => 6,
                'icon' => 'fa fa-print',
                'pages' => array()
            ),
            array(
                'label' => 'Solicitudes Por Aprobar',
                'uri' => null,
                'type' => 'MVC',
                'controller' => 'solicitudes',
                'action' => 'solicitudes-por-aprobar',
                'route' => 'application/default',
                'id' => 9,
                'icon' => 'fa fa-file-text',
                'pages' => array()
            ),
            array(
                'label' => 'Cumpleaños',
                'uri' => null,
                'type' => 'MVC',
                'controller' => 'cumpleanos',
                'action' => 'index',
                'route' => 'application/default',
                'id' => 10,
                'icon' => 'fa fa-birthday-cake',
                'pages' => array()
            )
        );
    }

    public function getIdentity($username, $credential) {

        $in = new RmwgetlsttrabuserIn();
        $in->setP_count(null);
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);

        $plsql = $this->getOracleServices()->getRmwgetlsttrabuser();
        $out = $plsql->execute($in);
        $cursor = $out->getRetorno();
        $row = $cursor[0];


        // establecemos los permisos
        $rbac = new \Zend\Permissions\Rbac\Rbac();
        $role = new \Zend\Permissions\Rbac\Role($row->getTrab_role());
        $rbac->addRole($role);

        $identityModel = new Identity();
        $identityModel->setId($row->getTrab_codigo());
        $identityModel->setNombreCompleto($row->getTrab_nombres());
        $identityModel->setRut($row->getTrab_rut());
        $identityModel->setUsername($username);
        $identityModel->setCredential($credential);
        $identityModel->setRbac($rbac);
        $identityModel->setFirstLogin($row->getChn_pass());
        
        return $identityModel;
    }

    public function findCumpleanos() {

        $in = new RmwgetlstcumpleanosIn();

        $in->setP_count(null);
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);
        $in->setP_trab_codigo(null);

        $plsql = $this->getOracleServices()->getRmwgetlstcumpleanos();
        $out = $plsql->execute($in);

        $cumpleanos = array();

        foreach ($out->getRetorno() as $row) {

            $cumpleano = new Cumpleanos();
            $cumpleano->setFechaNacimiento($row->trab_fecnac_fmt);
            $cumpleano->setNombre($row->trab_nombres);
            $cumpleano->setRut($row->trab_rut);

            $cumpleanos[] = $cumpleano;
        }


        return $cumpleanos;
    }

    public function findLiquidaciones() {

        $in = new RmwgetlstliquidacionesIn();

        $in->setP_count(null);
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);
        $in->setP_trab_codigo($this->getUser()->getId());

        $plsql = $this->getOracleServices()->getRmwgetlstliquidaciones();
        $out = $plsql->execute($in);
        return $out->getRetorno();
    }

    public function findLiquidacionDebito($per) {

        $in = new RmwgetlstliquidebitoIn();

        $in->setP_count(null);
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);
        $in->setP_peri_codigo($per);
        $in->setP_trab_codigo($this->getUser()->getId());

        $plsql = $this->getOracleServices()->getRmwgetlstliquidebito();
        $out = $plsql->execute($in);

        $debitos = array();

        foreach ($out->getRetorno() as $row) {
            $debito = new Debito();
            $debito->setLiquidacionVariableDescripcion($row->tado_dom_dscr);
            $debito->setLiquidacionVariable($row->liqu_variable);
            $debito->setValor($row->valor);
            $debito->setOrden($row->orden);
            $debitos[] = $debito;
        }

        return $debitos;
    }

    public function findLiquidacionHaber($per) {

        $in = new RmwgetlstliquihaberesIn();

        $in->setP_count(null);
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);
        $in->setP_peri_codigo($per);
        $in->setP_trab_codigo($this->getUser()->getId());


        $plsql = $this->getOracleServices()->getRmwgetlstliquihaberes();
        $out = $plsql->execute($in);

        $habiles = array();

        foreach ($out->getRetorno() as $row) {
            $habile = new Haberes();
            $habile->setLiquidacionVariable($row->liqu_variable);
            $habile->setLiquidacionVariableDescripcion($row->tado_dom_dscr);
            $habile->setValor($row->valor);
            $habile->setOrden($row->orden);
            $habiles[] = $habile;
        }

        return $habiles;
    }

    public function findLiquidacionEncabezado($per) {

        $in = new RmwgetlstliquiencIn();

        $in->setP_count(null);
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);
        $in->setP_peri_codigo($per);
        $in->setP_trab_codigo($this->getUser()->getId());

        $plsql = $this->getOracleServices()->getRmwgetlstliquienc();
        $out = $plsql->execute($in);

        $encabezados = array();

        foreach ($out->getRetorno() as $row) {

            $encabezado = new Liquidacion();
            $encabezado->setPeriodoCodigo($row->peri_codigo);
            $encabezado->setPeriodoDescripcion($row->peri_dscr);

            $encabezado->setEmpresaCodigo($row->empr_codigo);
            $encabezado->setEmpresaNombre($row->empr_nombre);
            $encabezado->setEmpresaRut($row->empr_rut);
            $encabezado->setEmpresaDireccion($row->empr_direc);
            $encabezado->setEmpresaCiudad($row->empr_ciud);

            $encabezado->setTrabajadorCodigo($row->trab_codigo);
            $encabezado->setTrabajadorRut($row->trab_rut);
            $encabezado->setTrabajadorNombre($row->nombre);
            $encabezado->setTrabajadorFechaIngreso($row->trab_fecingreso);

            $encabezado->setConCostoCodigo($row->ccto_codigo);
            $encabezado->setCargo($row->detr_cargo);
            $encabezado->setAfp($row->afp);
            $encabezado->setIsapre($row->isapre);
            $encabezado->setBanco($row->banco);
            $encabezado->setLiquido($row->liqu_liquido);

            $encabezados[] = $encabezado;
        }

        return $encabezados;
    }

    public function findMisSolicitudes() {

        $in = new RmwgetlstsolicitudesIn();

        $in->setP_count(0);
        $in->setP_estado(null);
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);
        $in->setP_trab_codigo($this->getUser()->getId());

        $plsql = $this->getOracleServices()->getRmwgetlstsolicitudes();
        $out = $plsql->execute($in);

        $solicitides = array();

        foreach ($out->getRetorno() as $row) {
            $solicitud = new Solicitud();
            $solicitud->setIdSolicitud($row->id_solic);
            $solicitud->setTipo(new Tipo($row->tipo, ucfirst(strtolower($row->tipo))));
            $solicitud->setObservaciones($row->obs);
            $solicitud->setEstado(new Estado($row->cod_estado, $row->tado_dom_dscr));
            $solicitud->setFechaIngreso($row->fecha_solic_fmt);
            $solicitides[] = $solicitud;
        }

        return $solicitides;
    }

    public function findSolicitudesPorAprobar() {

        $in = new RmwgetlstsolicitudesIn();

        $in->setP_count(0);
        $in->setP_estado('PENDIENTE');
        $in->setP_numreg(null);
        $in->setP_offset(null);
        $in->setP_ord_by(null);
        $in->setP_trab_codigo(null);

        $plsql = $this->getOracleServices()->getRmwgetlstsolicitudes();
        $out = $plsql->execute($in);

        $solicitudes = array();

        foreach ($out->getRetorno() as $row) {
            $solicitud = new Solicitud();
            $solicitud->setIdSolicitud($row->id_solic);
            $solicitud->setTipo(new Tipo($row->tipo, ucfirst(strtolower($row->tipo))));
            $solicitud->setObservaciones($row->obs);
            $solicitud->setEstado(new Estado($row->cod_estado, $row->tado_dom_dscr));
            $solicitud->setFechaIngreso($row->fecha_solic_fmt);
            $solicitud->setNombreTrabajador($row->trab_nombres);
            $solicitudes[] = $solicitud;
        }


        return $solicitudes;
    }

    public function cambiarClave($form) {

        $in = new RmwcambiopasswordIn();

        $in->setP_pass_anterior($form->get('password')->getValue());
        $in->setP_pass_nueva1($form->get('newPassword')->getValue());
        $in->setP_pass_nueva2($form->get('reNewPassword')->getValue());

        $plsql = $this->getOracleServices()->getRmwcambiopassword();
        $plsql->execute($in);
        $plsql->commit();
    }

}
