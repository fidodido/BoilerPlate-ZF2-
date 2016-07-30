<?php

namespace Padcore\Utils;

use Zend\Validator\AbstractValidator;

class MayorFechaActual extends AbstractValidator {

    const FORMAT = 'format';
    const DV = 'dv';

    protected $messageTemplates = array(
        self::FORMAT => "Debe ser <<Mayor>> o igual a la fecha actual",
    );

    public function isValid($value, $context = array()) {

        // por defecto es no valido.
        $isValid = false;

        $formato = "d-m-Y";
        $fecha = \DateTime::createFromFormat($formato, $value);
        $fechaActual = \DateTime::createFromFormat($formato, date($formato));

        if ($fecha >= $fechaActual) {
            $isValid = true;
        }

        $this->error(self::FORMAT);
        return $isValid;
    }

}
