<?php

namespace DevAdmin\Model\View\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RolForm extends Form {

    private $inputFilter;

    public function __construct($name = null) {

        parent::__construct($name);

        $this->add(array(
            'name' => 'idRol',
            'type' => 'Zend\Form\Element\Hidden'
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Nombre',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Descripción',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;

            $inputFilter->add(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'description',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
        }

        return $this->inputFilter;
    }

}
