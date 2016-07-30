<?php

namespace DevAdmin\Controller;

use Zend\View\Model\ViewModel;
use Util\BaseController;
USE DevAdmin\Model\View\Form\ConfigForm;

class ConfigController extends BaseController {

    public function globalAction() {

        $this->layout('layout/devadmin');

        $form = new ConfigForm();

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function logAction() {
        $this->layout('layout/devadmin');
        return new ViewModel();
    }

}
