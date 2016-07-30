<?php

namespace Padcore\Exception;

use Exception;

class SqlException extends Exception {

    public function __construct($message = null) {
        parent::__construct('SQL Exception', null, null);
    }

}
