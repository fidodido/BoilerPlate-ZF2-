<?php

namespace DevAdmin\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;
use Zend\Navigation\Page\AbstractPage;

class Page extends AbstractPage implements ArraySerializableInterface {

    private $checked = 0;

    public function getHref() {
        return true;
    }

    public function getChecked() {
        return $this->checked;
    }

    public function setChecked($checked) {
        $this->checked = $checked;
    }

    public function exchangeArray(array $array) {
        return $array;
    }

    public function getArrayCopy() {
        
    }

}
