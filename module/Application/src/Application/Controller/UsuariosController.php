<?php


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsuariosController extends AbstractActionController {

    public function perfilAction() {
        $repository = $this->getServiceLocator()->get('OracleRepository');
        $ficha = $repository->getFicha();

        return new ViewModel(array(
            'ficha' => $ficha,
        ));
    }

}
