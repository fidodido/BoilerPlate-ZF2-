<?php

namespace Auth\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CambiarClaveForm extends Form {

    private $inputFilter;

    public function __construct($name = null) {

        parent::__construct($name);

        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Tu Password Actual',
                'label_attributes' => array(
                    'class' => 'col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'class' => 'width-40',
            ),
        ));

        $this->add(array(
            'name' => 'newPassword',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Escribe tu nuevo Password',
                'label_attributes' => array(
                    'class' => 'col-xs-12 col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'class' => 'width-40'
            ),
        ));

        $this->add(array(
            'name' => 'reNewPassword',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Vuelve a Escribir tu nuevo Password',
                'label_attributes' => array(
                    'class' => 'col-xs-12 col-sm-3 control-label no-padding-right'
                ),
            ),
            'attributes' => array(
                'class' => 'width-40'
            ),
        ));
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;

            $inputFilter->add(array(
                'name' => 'password',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'newPassword',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'reNewPassword',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => '6',
                        )
                    ),
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'No coinciden. Revisa por favor que lo hayas ingresado bien.',
                            ),
                            'callback' => array($this, 'validarCoincidenciaPassword')
                        ),
                    )
                ),
            ));
        }

        return $this->inputFilter;
    }

    public function validarCoincidenciaPassword($value, $context = array()) {

        $isValid = false;

        if ($context['newPassword'] === $context['reNewPassword']) {
            $isValid = true;
        }

        return $isValid;
    }

}
