<?php

namespace Padcore\Utils;

use Zend\Validator\AbstractValidator;

class HoraMenor extends AbstractValidator {

    const FORMAT = 'format';
    const DV = 'dv';

    protected $messageTemplates = array(
        self::FORMAT => "Hora de término debe ser <<Mayor>> a la hora de inicio.",
    );

    public function isValid($value, $context = array()) {

        $isValid = false;

        // formato para comparar las dos fechas.
        $formato = "d-m-Y H:i";

        $fechaInicio = $context['fechaInicio'] . ' ' . substr($context['horaInicio'], 0, -3);
        $fechaTermino = $context['fechaInicio'] . ' ' . substr($context['horaTermino'], 0, -3);

        $fechaDesde = \DateTime::createFromFormat($formato, $fechaInicio);
        $fechaHasta = \DateTime::createFromFormat($formato, $fechaTermino);

        if ($fechaHasta > $fechaDesde) {
            $isValid = true;
        }

        $this->error(self::FORMAT);
        return $isValid;
    }

}
