<?php

namespace DevAdmin\Model\View\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class OptionMenuForm extends Form {

    private $inputFilter;

    const INTERNAL_URL = 'MVC';
    const EXTERNAL_URL = 'URI';

    public function __construct($name = null) {

        parent::__construct($name);

        $this->add(array(
            'name' => 'idOption',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'label',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Título',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'icon',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Ícono',
                'value_options' => array(
                    'asterisk' => 'asterisk',
                    'plus' => 'plus'
                ),
            ),
            'attributes' => array(
                'id' => 'icon-input',
                'class' => 'form-control input-sm'
            ),
        ));


        $this->add(array(
            'name' => 'parent',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Incluir debajo de la Opción',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'route',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => 'application/default',
            ),
        ));

        $this->add(array(
            'name' => 'controller',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Controlador',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'action',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Acción',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'url',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'URL',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
        ));

        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'type' => 'Radio',
                'label' => '¿Qué tipo de opción es?',
                'label_attributes' => array(
                    'class' => 'radio-inline'
                ),
                'value_options' => array(
                    self::INTERNAL_URL => 'MVC',
                    self::EXTERNAL_URL => 'URI'
                ),
            ),
            'attributes' => array(
                'value' => self::INTERNAL_URL,
            ),
        ));
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;
            $optionType = $this->get('type')->getValue();

            $inputFilter->add(array(
                'name' => 'label',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'icon',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'parent',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'route',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'type',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'InArray',
                        'options' => array(
                            'haystack' => array(self::INTERNAL_URL, self::EXTERNAL_URL),
                            'notInArray' => 'Input no valido.'
                        )
                    )
                ),
            ));

            $inputFilter->add(array(
                'name' => 'url',
                'required' => ($optionType == self::EXTERNAL_URL) ? true : false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'controller',
                'required' => ($optionType == self::INTERNAL_URL) ? true : false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'action',
                'required' => ($optionType == self::INTERNAL_URL) ? true : false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
        }

        return $this->inputFilter;
    }

    public function setParentValues($pages) {

        $parent = $this->get('parent')->getValue();

        $options = array(array(
                'value' => null,
                'label' => 'Raíz'
        ));

        foreach ($pages as $page) {

            $option = array(
                'value' => $page['id'],
                'label' => $page['label']
            );

            if ($parent == $page['id']) {
                $option['selected'] = true;
            }

            $options[] = $option;
        }

        $this->get('parent')->setValueOptions($options);
    }

}
