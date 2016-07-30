<?php

namespace Padcore\Utils;

use Zend\Validator\AbstractValidator;

class RutValidator extends AbstractValidator {

    const FORMAT = 'format';
    const DV = 'dv';

    protected $messageTemplates = array(
        self::FORMAT => "Rut no válido",
        self::DV => "Dígito verificador no válido"
    );

    public function isValid($value) {
        
        $this->setValue((string) $value);
        $isValid = true;
        
        $value = str_replace("-", "", $value);
        
        // primero validamos si el rut tiene el formato adecuado. 
        // ejemplo: 12.345.678-9
        $status = preg_match("/^\d{7,8}[0-9kK]{1}$/", $value);

        if (0 === $status) {
            $this->error(self::FORMAT);
            $isValid = false;
        }

        // despues validamos que el digito verificador sea valido.
        $digitoVerificador = substr($value, -1);
        $rutLimpio = preg_replace('/(\.)|(\-)|[ ]|[\,]|[\']/', '', $value);
        $rutSinDigito = substr($rutLimpio, 0, strlen($rutLimpio) - 1);

        $dv = $this->calculaDV($rutSinDigito);

        if($digitoVerificador == "k") {
            $digitoVerificador = "K";
        }

        if ($dv != $digitoVerificador) {
            $this->error(self::FORMAT);
            $isValid = false;
        }

        return $isValid;
    }

    public function calculaDV($r) {
        $s = 1;
        for ($m = 0; $r != 0; $r/=10)
            $s = ($s + $r % 10 * (9 - $m++ % 6)) % 11;
        return chr($s ? $s + 47 : 75);
    }

}
