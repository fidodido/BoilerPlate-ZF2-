<?php

namespace Padcore\Persistence;

use Padcore\Persistence\Parameter;
use Padcore\Persistence\SqlParameter;
use Padcore\Persistence\SqlOutParameter;

class StoredProcedure {

    private $name = null;
    private $isFunction;
    private $params = array();
    private $errors;
    private $connection;

    /*
     * Formato que se le debe pasar a los parametros de entrada tipo 'date'
     */

    const DATE_IN_FORMAT = 'd M Y';

    /*
     * Formato que retorna los parametros de salida tipo 'date'.
     */
    const DATE_OUT_FORMAT = 'd-M-y';

    /*
     * Foramto de fecha Estandard para la aplicación. 
     */
    const DATE_APP_STANDARD = 'd/m/Y';

    /*
     * Por defecto solo el nombre del parametro.
     */

    public function __construct($name = null) {
        $this->name = $name;
    }

    public function setConnection($connection) {
        $this->connection = $connection;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setErrors($errors) {
        $this->errors = $errors;
    }

    public function getConnection() {
        if (!$this->connection) {
            throw new \Exception('No existe adaptador');
        }

        return $this->connection;
    }

    public function getName() {
        return $this->name;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getParams() {
        return $this->params;
    }

    public function declareParam($parameter) {
        // si el parametro es TIMESTAMP-
        if ($parameter->getType() == Parameter::TIMESTAMP && $parameter instanceof SqlParameter) {
            $this->formatInDate($parameter);
        }

        $this->params[] = $parameter;
    }

    /*
     * Los PLSQL que tengan parametros de entrada tipo 'date'
     * la fecha debe tener el siguiente formato: d M Y.
     * De otra forma daría error.
     * En cuanto a esta Clase, 
     * Solo se reciben parametros con el formato d/m/y de entrada
     * de lo contrario da error.
     */

    private function formatInDate($parameter) {

        $fecha = $parameter->getValue();

        if (!empty($fecha)) {

            $fecha = $parameter->getValue();

            $fechaObject = \DateTime::createFromFormat(self::DATE_APP_STANDARD, $fecha);
            $errors = \DateTime::getLastErrors();

            if ($errors['error_count'] != 0) {
                throw new \Exception('Este formato de fecha (' . $parameter->getName() . ') no esta permitido: ' . $fecha . ', Debe ser d/m/Y');
            }

            $parameter->setValue($fechaObject->format(self::DATE_IN_FORMAT));
        }
    }

    /*
     * Los PLSQL que tengan parametros de salida tipo 'date'
     * vienen en el formato d M Y, por lo tanto automaticamente
     * serian formateados a d/m/Y
     */

    private function formatOutDate($fecha) {

        $fechaObject = \DateTime::createFromFormat(self::DATE_OUT_FORMAT, $fecha);
        $errors = \DateTime::getLastErrors();

        if ($errors['error_count'] != 0) {
            throw new \Exception('Procedimiento devolvio formato de fecha erroneo: ' . $fecha);
        }

        return $fechaObject->format(self::DATE_APP_STANDARD);
    }

    public function commit() {
        $connection = $this->getConnection();
        oci_commit($connection);
    }

    public function closeConnection() {
        $connection = $this->getConnection();
        oci_close($connection);
    }

    public function rollback() {
        $connection = $this->getConnection();
        oci_rollback($connection);
    }

    public function setFunction($boolean) {
        if (!is_bool($boolean)) {
            throw new \Exception('La variable ingresada debe ser booleanada.');
        }
        $this->isFunction = $boolean;
    }

    private function isFunction() {
        return $this->isFunction ? true : false;
    }

    public function execute() {


        if (!$this->getConnection()) {
            throw new \Exception('No se ha definido la conexion.');
        }

        if (!$this->getName()) {
            throw new \Exception('Debe especificar un Nombre al procedimiento.');
        }

        // construyo el SQL.
        $query = $this->buildStringQuery();

        $connection = $this->getConnection();
        $result = array();

        // compilamos -->
        $stmt = oci_parse($connection, $query);

        $data = array();

        foreach ($this->params as $param) {

            if ($param instanceof SqlParameter) {

                $name = $param->getName();
                $data[$param->getName()] = $param->getValue();

                oci_bind_by_name($stmt, $name, $data[$param->getName()], 32767);
            }

            if ($param instanceof SqlOutParameter) {


                if ($param->getType() == Parameter::CURSOR) {

                    $tmpCursor = oci_new_cursor($connection);
                    $result[$param->getName()] = $tmpCursor;
                    oci_bind_by_name($stmt, $param->getName(), $tmpCursor, -1, OCI_B_CURSOR);
                } else {
                    oci_bind_by_name($stmt, $param->getName(), $result[$param->getName()], 32767);
                }
            }
        }

        // por defecto los procedimientos no hacen commit.
        @oci_execute($stmt, OCI_NO_AUTO_COMMIT);

        // obtengo los errores si es que existen.
        $errors = oci_error($stmt);
        
        
        // hay errores ?
        if ($errors) {
            // seteo los errores y termino la ejecución del método -->
            $this->setErrors($errors);
            return false;
        }


        // recorro cada parametro y si es cursor, hago un fetch de los datos.
        foreach ($this->getParams() as $param) {

            /*
             * Cada parametro de tipo cursor, necesita ser recogido
             * de forma independiente.
             * Por eso se recorre nuevamente los parametros.
             */
            if ($param->getType() == Parameter::CURSOR) {
                oci_execute($result[$param->getName()]);
                oci_fetch_all($result[$param->getName()], $cursorArray, null, null, OCI_FETCHSTATEMENT_BY_ROW);
                $result[$param->getName()] = $cursorArray;
            }

            /*
             *  Los parametros de salida tipo 'date'
             * Oracle los retorna con el formato d/M/y
             * se debe transformar al formato estandar d/m/Y
             */

            if ($param->getType() == Parameter::TIMESTAMP && $param instanceof SqlOutParameter) {
                $fechaRetornada = $result[$param->getName()];
                $fechaFormateada = $this->formatOutDate($fechaRetornada);
                $result[$param->getName()] = $fechaFormateada;
            }
        }

        // libero el recurso asociado.
        oci_free_statement($stmt);

        // dejo en null la variable parametros.
        $this->params = null;
        // retorno el resultado.
        return $result;
    }

    private function buildStringQuery() {

        $query = "";

        // es una funcion ??
        if ($this->isFunction()) {
            $query .= 'BEGIN :retorno := ' . $this->getName() . '(';
        } else {
            $query .= 'BEGIN ' . $this->getName() . '(';
        }

        $max = count($this->params) - 1;

        foreach ($this->params as $key => $param) {

            if ($param->getName() != 'retorno') {
                if ($max != $key) {
                    $query .= ':' . $param->getName() . ',';
                } else {
                    $query .= ':' . $param->getName();
                }
            }
        }

        $query .= ');END;';
        return $query;
    }

}
