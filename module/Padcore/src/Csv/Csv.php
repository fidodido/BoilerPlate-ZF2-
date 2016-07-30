<?php

namespace Padcore\Csv;

class Csv {

    public static function Generate($lineas) {

        $sysTempDir = sys_get_temp_dir();
        $archivoNomnre = '_comisiones_csv_temporal_' . uniqid();

        $path = $sysTempDir . '/' . $archivoNomnre;

        $fp = fopen($path, 'w');

        foreach ($lineas as $value) {
            fwrite($fp, $value . PHP_EOL);
        }

        return $path;
    }

}
