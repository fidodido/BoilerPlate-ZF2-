<?php

namespace Padcore\Utils;

use Zend\Validator\AbstractValidator;

class FechaMenor extends AbstractValidator {

    const FORMAT = 'format';
    const DV = 'dv';

    protected $messageTemplates = array(
        self::FORMAT => "Fecha próxima debe ser mayor a fecha actual incluida la hora.",
    );

    public function isValid($value, $context = array()) {

        // por defecto es no valido.
        $isValid = false;

        // formato para comparar las dos fechas.
        $formato = "d-m-Y H:i A";

        $fechaOriginal = $context['fechaOriginal'] . ' ' . $context['horaOriginal'];
        $fechaOriginalDate = \DateTime::createFromFormat($formato, $fechaOriginal);

        $fechaProxima = $context['fechaVisita'] . ' ' . $context['horaVisita'];
        $fechaProximaDate = \DateTime::createFromFormat($formato, $fechaProxima);

        if ($fechaProximaDate > $fechaOriginalDate) {
            $isValid = true;
        }

        $this->error(self::FORMAT);
        return $isValid;
    }

}
