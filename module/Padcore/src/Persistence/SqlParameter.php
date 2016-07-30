<?php

namespace Padcore\Persistence;

use Padcore\Persistence\Parameter;

class SqlParameter extends Parameter {

    protected $name;
    protected $type;
    protected $value;
    
    public function __construct($name, $type, $value) {

        parent::__construct();

        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
    }

}
