<?php

namespace Application\Controller;

use Util\BaseController;
use Zend\View\Model\ViewModel;
use Application\Form\AnticiposForm;
use Application\Model\Entity\Anticipo;
use Application\Model\Entity\Estado;

class AnticiposController extends BaseController {

    public function agregarAction() {

        $form = new AnticiposForm("form");

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            $form->setInputFilter($form->getInputFilter());
            if ($form->isValid()) {

                $anticiposModel = new Anticipo();
                $anticiposModel->exchangeArray($data);

                $id = $this->getServiceLocator()
                        ->get(\Repository\Entity\Repository::ORACLE)
                        ->saveSolicitudAnticipo($anticiposModel);

                $this->flashMessenger()->addMessage(array(
                    'message' => \Util\Message::SUCCESS,
                    'className' => \Util\Message::CLASS_SUCCESS
                ));

                return $this->redirect()->toRoute('application/default', array('controller' => 'anticipos', 'action' => 'detalle'), array('query' => array('id' => $id)));
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
                ->findSolicitudAnticipos($id);

        return new ViewModel(array(
            'solicitud' => $solicitud
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
                        ->findSolicitudAnticipos($form->get('id')->getValue());

                $newEstado = new Estado($solicitud->getEstadoPorAccion($form->get('action')->getValue()));
                $solicitud->setEstado($newEstado);
                $solicitud->setObservaciones($form->get('observacion')->getValue());

                $this->getServiceLocator()
                        ->get(\Repository\Entity\Repository::ORACLE)
                        ->saveSolicitudAnticipo($solicitud);

                $this->flashMessenger()->addMessage(array(
                    'message' => \Util\Message::SUCCESS,
                    'className' => \Util\Message::CLASS_SUCCESS
                ));

                return $this->redirect()->toRoute('application/default', array('controller' => 'anticipos', 'action' => 'detalle'), array('query' => array('id' => $form->get('id')->getValue())));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'messages' => $this->getFlashMessages()
        ));
    }

}
