<?php

namespace Padcore\Utils;

class Rut {

    public static function clean($rut) {

        $rut = str_replace(array('.', ',', '-'), '', $rut);
        $formattedRut = substr($rut, 0, -1);
        return $formattedRut;
    }
    
    /**
     * 
     * @param type $rut
     * @return type
     * Devuelve el ultimo caracter del string
     */
    public static function getDv($rut) {
        return substr($rut, -1);
    }

}
