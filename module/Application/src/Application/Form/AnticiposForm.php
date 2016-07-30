<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class AnticiposForm extends Form {

    private $inputFilter;

    public function __construct($name = null) {

        parent::__construct($name);

        $this->add(array(
            'name' => 'fechaIngreso',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Fecha Solicitud',
                'label_attributes' => array(
                    'class' => 'col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'id' => 'fecha_solicitud',
                'class' => 'width-40',
                'value' => date('d/m/Y'),
                'readonly' => 'readonly'
            ),
        ));

        $this->add(array(
            'name' => 'fechaAbono',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Fecha de Abono',
                'label_attributes' => array(
                    'class' => 'col-xs-12 col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'id' => 'fecha_abono',
                'class' => 'width-40'
            ),
        ));

        $this->add(array(
            'name' => 'estado',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'estado_solicitud',
                'class' => 'col-md-12 col-xs-12',
            ),
        ));

        $this->add(array(
            'name' => 'monto',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => 'Monto',
                'label_attributes' => array(
                    'class' => 'col-xs-12 col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'id' => 'monto',
                'class' => 'width-40'
            ),
        ));

        $this->add(array(
            'name' => 'observaciones',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'id' => 'observaciones',
                'class' => 'form-control col-md-12 col-xs-12',
                'rows' => '5',
                'style' => 'width: 78em;'
            ),
        ));
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;

            $inputFilter->add(array(
                'name' => 'fechaIngreso',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'fechaAbono',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'Debe ser mayor a la "Fecha de Solicitud".',
                            ),
                            'callback' => array($this, 'validarFechaSolicitud')
                        ),
                    )
                ),
            ));

            $inputFilter->add(array(
                'name' => 'estado',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'monto',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Between',
                        'options' => array(
                            'min' => 1,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'observaciones',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
        }

        return $this->inputFilter;
    }

    public function validarFechaSolicitud($value, $context = array()) {

        $isValid = false;

        $formato = "d/m/Y";
        $fechaAbono = \DateTime::createFromFormat($formato, $context['fechaAbono']);
        $fechaIngreso = \DateTime::createFromFormat($formato, $context['fechaIngreso']);

        if ($fechaAbono >= $fechaIngreso) {
            $isValid = true;
        }

        return $isValid;
    }

}
