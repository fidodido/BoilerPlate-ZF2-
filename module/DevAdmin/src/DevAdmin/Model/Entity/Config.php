<?php

namespace DevAdmin\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;

class Config implements ArraySerializableInterface {

    private $title;
    private $logname;
    private $logfilter;

    public function getTitle() {
        return $this->title;
    }

    public function getLogname() {
        return $this->logname;
    }

    public function getLogfilter() {
        return $this->logfilter;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setLogname($logname) {
        $this->logname = $logname;
    }

    public function setLogfilter($logfilter) {
        $this->logfilter = $logfilter;
    }

    public function exchangeArray(array $array) {
        
    }

    public function getArrayCopy() {
        
    }

}
