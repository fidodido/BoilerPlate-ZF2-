<?php

namespace Auth\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class AuthenticationForm extends Form {

    private $inputFilter;

    public function __construct($name = null) {

        parent::__construct($name);

        $this->add(array(
            'name' => 'identity',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Username',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'credential',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Password',
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
                'name' => 'identity',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'credential',
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
