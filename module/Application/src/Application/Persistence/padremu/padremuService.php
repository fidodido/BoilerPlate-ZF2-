<?php
namespace Application\Persistence\padremu;
use Application\Persistence\padremu\Rmwcambiopassword;
use Application\Persistence\padremu\Rmwgetcertificado;
use Application\Persistence\padremu\Rmwgetfechaformteada;
use Application\Persistence\padremu\Rmwgetlstanticipos;
use Application\Persistence\padremu\Rmwgetlstcumpleanos;
use Application\Persistence\padremu\Rmwgetlstdominio;
use Application\Persistence\padremu\Rmwgetlstficha;
use Application\Persistence\padremu\Rmwgetlstliquidaciones;
use Application\Persistence\padremu\Rmwgetlstliquidebito;
use Application\Persistence\padremu\Rmwgetlstliquienc;
use Application\Persistence\padremu\Rmwgetlstliquihaberes;
use Application\Persistence\padremu\Rmwgetlstsolicitudes;
use Application\Persistence\padremu\Rmwgetlsttrabajador;
use Application\Persistence\padremu\Rmwgetlsttrabuser;
use Application\Persistence\padremu\Rmwgetlstvacaciones;
use Application\Persistence\padremu\Rmwgrabaanticipo;
use Application\Persistence\padremu\Rmwgrabavacaciones;
use Padcore\Persistence\StoredProcedure;

class padremuService {

    private $connection;
    private $Rmwcambiopassword;
    private $Rmwgetcertificado;
    private $Rmwgetfechaformteada;
    private $Rmwgetlstanticipos;
    private $Rmwgetlstcumpleanos;
    private $Rmwgetlstdominio;
    private $Rmwgetlstficha;
    private $Rmwgetlstliquidaciones;
    private $Rmwgetlstliquidebito;
    private $Rmwgetlstliquienc;
    private $Rmwgetlstliquihaberes;
    private $Rmwgetlstsolicitudes;
    private $Rmwgetlsttrabajador;
    private $Rmwgetlsttrabuser;
    private $Rmwgetlstvacaciones;
    private $Rmwgrabaanticipo;
    private $Rmwgrabavacaciones;
	
    public function __construct($connection) {
        $this->connection = $connection;
    }
	
    public function getRmwcambiopassword() {
        if (!$this->Rmwcambiopassword) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwcambiopassword = new Rmwcambiopassword();
            $this->Rmwcambiopassword->setProcedure($plsql);
        }
        return $this->Rmwcambiopassword;
    }
    public function getRmwgetcertificado() {
        if (!$this->Rmwgetcertificado) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetcertificado = new Rmwgetcertificado();
            $this->Rmwgetcertificado->setProcedure($plsql);
        }
        return $this->Rmwgetcertificado;
    }
    public function getRmwgetfechaformteada() {
        if (!$this->Rmwgetfechaformteada) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetfechaformteada = new Rmwgetfechaformteada();
            $this->Rmwgetfechaformteada->setProcedure($plsql);
        }
        return $this->Rmwgetfechaformteada;
    }
    public function getRmwgetlstanticipos() {
        if (!$this->Rmwgetlstanticipos) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstanticipos = new Rmwgetlstanticipos();
            $this->Rmwgetlstanticipos->setProcedure($plsql);
        }
        return $this->Rmwgetlstanticipos;
    }
    public function getRmwgetlstcumpleanos() {
        if (!$this->Rmwgetlstcumpleanos) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstcumpleanos = new Rmwgetlstcumpleanos();
            $this->Rmwgetlstcumpleanos->setProcedure($plsql);
        }
        return $this->Rmwgetlstcumpleanos;
    }
    public function getRmwgetlstdominio() {
        if (!$this->Rmwgetlstdominio) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstdominio = new Rmwgetlstdominio();
            $this->Rmwgetlstdominio->setProcedure($plsql);
        }
        return $this->Rmwgetlstdominio;
    }
    public function getRmwgetlstficha() {
        if (!$this->Rmwgetlstficha) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstficha = new Rmwgetlstficha();
            $this->Rmwgetlstficha->setProcedure($plsql);
        }
        return $this->Rmwgetlstficha;
    }
    public function getRmwgetlstliquidaciones() {
        if (!$this->Rmwgetlstliquidaciones) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstliquidaciones = new Rmwgetlstliquidaciones();
            $this->Rmwgetlstliquidaciones->setProcedure($plsql);
        }
        return $this->Rmwgetlstliquidaciones;
    }
    public function getRmwgetlstliquidebito() {
        if (!$this->Rmwgetlstliquidebito) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstliquidebito = new Rmwgetlstliquidebito();
            $this->Rmwgetlstliquidebito->setProcedure($plsql);
        }
        return $this->Rmwgetlstliquidebito;
    }
    public function getRmwgetlstliquienc() {
        if (!$this->Rmwgetlstliquienc) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstliquienc = new Rmwgetlstliquienc();
            $this->Rmwgetlstliquienc->setProcedure($plsql);
        }
        return $this->Rmwgetlstliquienc;
    }
    public function getRmwgetlstliquihaberes() {
        if (!$this->Rmwgetlstliquihaberes) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstliquihaberes = new Rmwgetlstliquihaberes();
            $this->Rmwgetlstliquihaberes->setProcedure($plsql);
        }
        return $this->Rmwgetlstliquihaberes;
    }
    public function getRmwgetlstsolicitudes() {
        if (!$this->Rmwgetlstsolicitudes) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstsolicitudes = new Rmwgetlstsolicitudes();
            $this->Rmwgetlstsolicitudes->setProcedure($plsql);
        }
        return $this->Rmwgetlstsolicitudes;
    }
    public function getRmwgetlsttrabajador() {
        if (!$this->Rmwgetlsttrabajador) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlsttrabajador = new Rmwgetlsttrabajador();
            $this->Rmwgetlsttrabajador->setProcedure($plsql);
        }
        return $this->Rmwgetlsttrabajador;
    }
    public function getRmwgetlsttrabuser() {
        if (!$this->Rmwgetlsttrabuser) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlsttrabuser = new Rmwgetlsttrabuser();
            $this->Rmwgetlsttrabuser->setProcedure($plsql);
        }
        return $this->Rmwgetlsttrabuser;
    }
    public function getRmwgetlstvacaciones() {
        if (!$this->Rmwgetlstvacaciones) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgetlstvacaciones = new Rmwgetlstvacaciones();
            $this->Rmwgetlstvacaciones->setProcedure($plsql);
        }
        return $this->Rmwgetlstvacaciones;
    }
    public function getRmwgrabaanticipo() {
        if (!$this->Rmwgrabaanticipo) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgrabaanticipo = new Rmwgrabaanticipo();
            $this->Rmwgrabaanticipo->setProcedure($plsql);
        }
        return $this->Rmwgrabaanticipo;
    }
    public function getRmwgrabavacaciones() {
        if (!$this->Rmwgrabavacaciones) {
            $plsql = new StoredProcedure();
            $plsql->setConnection($this->connection);
            $this->Rmwgrabavacaciones = new Rmwgrabavacaciones();
            $this->Rmwgrabavacaciones->setProcedure($plsql);
        }
        return $this->Rmwgrabavacaciones;
    }
}


