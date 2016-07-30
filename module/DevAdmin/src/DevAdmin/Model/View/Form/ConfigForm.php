<?php

namespace DevAdmin\Model\View\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Log\Logger;

class ConfigForm extends Form {

    private $inputFilter;

    public function __construct($name = null) {

        parent::__construct($name);

        $this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Título',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'logo',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Título',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'logname',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Nombre Fichero Log',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'zona',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Zona Horaria',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'logfilter',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Filtro Nivel Log',
                'value_options' => array(
                    Logger::EMERG => 'EMERG',
                    Logger::ALERT => 'ALERT',
                    Logger::CRIT => 'CRIT',
                    Logger::ERR => 'ERR',
                    Logger::WARN => 'WARG',
                    Logger::NOTICE => 'NOTICE',
                    Logger::INFO => 'INFO',
                    Logger::DEBUG => 'DEBUG',
                ),
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
        }

        return $this->inputFilter;
    }

}
