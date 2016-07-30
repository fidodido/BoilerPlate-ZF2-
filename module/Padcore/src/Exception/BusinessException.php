<?php

namespace Padcore\Exception;

use Exception;

class BusinessException extends Exception {

    public function __construct($des_err = null, $cod_err = null) {
        parent::__construct($des_err, $cod_err);
    }
    
}
