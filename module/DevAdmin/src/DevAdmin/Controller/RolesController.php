<?php

namespace DevAdmin\Controller;

use Util\BaseController;
use Zend\View\Model\ViewModel;
use DevAdmin\Model\View\Form\RolForm;
use DevAdmin\Model\Entity\Rol;

class RolesController extends BaseController {

    public function indexAction() {

        $this->layout('layout/devadmin');
        $repository = $this->getServiceLocator()->get('RolRepository');
        $roles = $repository->find();

        $flashMessenger = $this->flashMessenger();
        $messages = array();

        if ($flashMessenger->hasMessages()) {
            $messages = $flashMessenger->getMessages();
        }

        return new ViewModel(array(
            'roles' => $roles,
            'messages' => $messages
        ));
    }

    public function addAction() {

        $this->layout('layout/devadmin');

        $form = new RolForm();

        $pages = $this->getServiceLocator()->get('MenuRepository')->find();
        $permission = $this->getServiceLocator()->get('PermissionRepository')->find();

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {

                $rol = new Rol();
                $rol->exchangeArray($data);
                $this->getServiceLocator()->get('RolRepository')->save($rol);

                $this->flashMessenger()->addMessage(array('msg' => "La acción se ha efectuado correctamente."));
                return $this->redirect()->toRoute('devadmin/default', array('controller' => 'roles', 'action' => 'index'));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'pages' => $pages,
            'permission' => $permission
        ));
    }

    public function editAction() {
        
        $idRol = $this->params()->fromQuery('id');
        $this->layout('layout/devadmin');

        $rol = $this->getServiceLocator()
                ->get('RolRepository')
                ->findById($idRol);

        $available = $this->getServiceLocator()
                ->get('PermissionRepository')
                ->findAvailable($idRol);

        $assigned = $this->getServiceLocator()
                ->get('PermissionRepository')
                ->findAssigned($idRol);

        $pages = $this->getServiceLocator()
                ->get('MenuRepository')
                ->findPagesByRol($idRol);
       

        $form = new RolForm();
        $form->populateValues($rol->getArrayCopy());

        $flashMessenger = $this->flashMessenger();
        $messages = array();

        if ($flashMessenger->hasMessages()) {
            $messages = $flashMessenger->getMessages();
        }

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {
                $rol = new Rol();
                $rol->exchangeArray($data);
                $this->getServiceLocator()->get('RolRepository')->save($rol);
                $this->flashMessenger()->addMessage(array('msg' => "La acción se ha efectuado correctamente."));
                return $this->redirect()->toRoute('devadmin/default', array('controller' => 'roles', 'action' => 'edit'), array('query' => array('id' => $idRol)));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'rol' => $rol,
            'available' => $available,
            'assigned' => $assigned,
            'pages' => $pages,
            'messages' => $messages
        ));
    }

}
