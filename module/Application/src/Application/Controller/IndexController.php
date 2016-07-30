<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Util\BaseController;

class IndexController extends BaseController {

    public function indexAction() {

        $months = array(
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        );

        $repository = $this->getServiceLocator()->get('OracleRepository');
        $solicitudes = $repository->findMisSolicitudes();
        $cumpleanos = $repository->findCumpleanos();

        return new ViewModel(array(
            'solicitudes' => $solicitudes,
            'months' => $months,
            'cumpleanos' => $cumpleanos,
        ));
    }

    public function testAction() {

        $this->flashMessenger()->addMessage(array(
            'message' => \Util\Message::SUCCESS,
            'className' => \Util\Message::CLASS_ERROR
        ));

        return $this->redirect()->toRoute('application/default', array('controller' => 'index', 'action' => 'index'));
    }

}
