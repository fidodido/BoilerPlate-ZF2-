<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class TransicionForm extends Form {

    private $inputFilter;

    public function __construct($name = null) {

        parent::__construct($name);

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'action',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'observacion',
            'type' => 'Zend\Form\Element\TextArea',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'rows' => 5,
                'cols' => 60
            ),
            'options' => array(
                'label' => '¿Alguna Observación?:',
                'label_attributes' => array(
                    'class' => 'col-sm-3 control-label no-padding-right'
                ),
            ),
        ));
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;

            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'action',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'observacion',
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
