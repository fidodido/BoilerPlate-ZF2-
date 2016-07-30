<?php

namespace Padcore\Persistence;

use Padcore\Persistence\Parameter;

class SqlOutParameter extends Parameter {

    protected $name;
    protected $type;

    public function __construct($name, $type) {

        parent::__construct();

        $this->name = $name;
        $this->type = $type;
    }

}
