<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class VacacionesForm extends Form {

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
            'name' => 'fechaInicio',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Fecha de Inicio',
                'label_attributes' => array(
                    'class' => 'col-xs-12 col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'id' => 'fecha_inicio',
                'class' => 'width-40'
            ),
        ));

        $this->add(array(
            'name' => 'fechaTermino',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Fecha de Término',
                'label_attributes' => array(
                    'class' => 'col-xs-12 col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'id' => 'fecha_termino',
                'class' => 'width-40'
            ),
        ));

        $this->add(array(
            'name' => 'diasHabiles',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => 'Días Hábiles',
                'label_attributes' => array(
                    'class' => 'col-xs-12 col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'id' => 'dias_habiles',
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

        $this->add(array(
            'name' => 'estado',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'estado_solicitud',
                'class' => 'col-md-12 col-xs-12',
            ),
        ));
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;


            $inputFilter->add(array(
                'name' => 'fechaIngreso',
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'La "Fecha de Solicitud" debe ser menor que la "Fecha de Inicio" y "Fecha de Término"',
                            ),
                            'callback' => array($this, 'validarFechaSolicitudFechaActual')
                        ),
                    )
                ),
            ));

            $inputFilter->add(array(
                'name' => 'fechaInicio',
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
                'name' => 'fechaTermino',
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
                                \Zend\Validator\Callback::INVALID_VALUE => 'Debe ser mayor a la "Fecha de Inicio".',
                            ),
                            'callback' => array($this, 'validarFechaHastaAnterior')
                        ),
                    )
                ),
            ));

            $inputFilter->add(array(
                'name' => 'diasHabiles',
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

            $inputFilter->add(array(
                'name' => 'estado',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
        }

        return $this->inputFilter;
    }

    public function validarFechaHastaAnterior($value, $context = array()) {

        $isValid = false;

        $formato = "d/m/Y";
        $fechaInicio = \DateTime::createFromFormat($formato, $context['fechaInicio']);
        $fechaTermino = \DateTime::createFromFormat($formato, $context['fechaTermino']);
        $fechaIngreso = \DateTime::createFromFormat($formato, $context['fechaIngreso']);

        if (($fechaTermino >= $fechaInicio) && ($fechaTermino >= $fechaIngreso)) {
            $isValid = true;
        }

        return $isValid;
    }

    public function validarFechaSolicitud($value, $context = array()) {

        $isValid = false;

        $formato = "d/m/Y";
        $fechaInicio = \DateTime::createFromFormat($formato, $context['fechaInicio']);
        $fechaIngreso = \DateTime::createFromFormat($formato, $context['fechaIngreso']);

        if ($fechaInicio >= $fechaIngreso) {
            $isValid = true;
        }

        return $isValid;
    }

    public function validarFechaSolicitudFechaActual($value, $context = array()) {

        $isValid = false;

        $formato = "d/m/Y";
        $fechaInicio = \DateTime::createFromFormat($formato, $context['fechaInicio']);
        $fechaTermino = \DateTime::createFromFormat($formato, $context['fechaTermino']);
        $fechaIngreso = \DateTime::createFromFormat($formato, $context['fechaIngreso']);

        if (($fechaIngreso <= $fechaInicio) && ($fechaIngreso <= $fechaTermino)) {
            $isValid = true;
        }

        return $isValid;
    }

}
