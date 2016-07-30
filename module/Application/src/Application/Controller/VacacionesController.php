<?php


namespace Application\Controller;

use Util\BaseController;
use Zend\View\Model\ViewModel;
use Application\Form\VacacionesForm;
use Application\Model\Entity\Vacaciones;
use Application\Model\Entity\Estado;

class VacacionesController extends BaseController {

    public function agregarAction() {

        $repository = $this->getServiceLocator()->get(\Repository\Entity\Repository::ORACLE);
        $form = new VacacionesForm();

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {

                $vacacionesModel = new Vacaciones();
                $vacacionesModel->exchangeArray($data);
                $id = $repository->saveSolicitudVacaciones($vacacionesModel);

                $this->flashMessenger()->addMessage(array(
                    'message' => \Util\Message::SUCCESS,
                    'className' => \Util\Message::CLASS_SUCCESS
                ));

                return $this->redirect()->toRoute('application/default', array('controller' => 'vacaciones', 'action' => 'detalle'), array('query' => array('id' => $id, 'tipo' => 'VACACIONES')));
            }
        }

        return new ViewModel(array(
            "form" => $form
        ));
    }

    public function transicionAction() {

        $query = $this->params()->fromQuery();
        $form = new \Application\Form\TransicionForm();
        $form->populateValues($query);

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {

                /* @var $solicitud Vacaciones */
                $solicitud = $this->getServiceLocator()
                        ->get(\Repository\Entity\Repository::ORACLE)
                        ->findSolicitudVacaciones($form->get('id')->getValue());

                $newEstado = new Estado($solicitud->getEstadoPorAccion($form->get('action')->getValue()));
                $solicitud->setEstado($newEstado);
                $solicitud->setObservaciones($form->get('observacion')->getValue());

                $this->getServiceLocator()
                        ->get(\Repository\Entity\Repository::ORACLE)
                        ->saveSolicitudVacaciones($solicitud);

                $this->flashMessenger()->addMessage(array(
                    'message' => \Util\Message::SUCCESS,
                    'className' => \Util\Message::CLASS_SUCCESS
                ));
                
                return $this->redirect()->toRoute('application/default', array('controller' => 'vacaciones', 'action' => 'detalle'), array('query' => array('id' => $form->get('id')->getValue())));
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function detalleAction() {
        
        $id = $this->params()->fromQuery('id');

        if (!isset($id)) {
            throw new Exception("Solicitud no valida.", 1);
        }

        $solicitud = $this->getServiceLocator()
                ->get(\Repository\Entity\Repository::ORACLE)
                ->findSolicitudVacaciones($id);

        return new ViewModel(array(
            'solicitud' => $solicitud
        ));
    }

}
