<?php

namespace Padcore\Persistence;

class Parameter {

    const NUMERIC = 1;
    const VARCHAR = 2;
    const CURSOR = 3;
    const TIMESTAMP = 4;
    
    protected $name;
    protected $type;
    protected $value;
    
    public function __construct() {
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getValue() {
        return $this->value;
    }
    
    public function setValue($value) {
        $this->value = $value;
    }

}
