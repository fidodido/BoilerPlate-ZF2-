<?php

namespace DevAdmin\Controller;

use Util\BaseController;
use Zend\View\Model\ViewModel;
use DevAdmin\Model\View\Form\UserForm;
use DevAdmin\Model\Entity\User;

class UsersController extends BaseController {

    public function indexAction() {

        $this->layout('layout/devadmin');
        $repository = $this->getServiceLocator()->get('UserRepository');
        $users = $repository->find();

        $flashMessenger = $this->flashMessenger();
        $messages = array();

        if ($flashMessenger->hasMessages()) {
            $messages = $flashMessenger->getMessages();
        }

        return new ViewModel(array(
            'users' => $users,
            'messages' => $messages
        ));
    }

    public function addAction() {

        $this->layout('layout/devadmin');
        $form = new UserForm();

        $rolRepository = $this->getServiceLocator()->get('RolRepository');
        $rolesAvailable = $rolRepository->find();

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {
                $user = new User();
                $user->exchangeArray($data);
                $this->getServiceLocator()->get('UserRepository')->save($user);
                $this->flashMessenger()->addMessage(array('msg' => "La acción se ha efectuado correctamente."));
                return $this->redirect()->toRoute('devadmin/default', array('controller' => 'users', 'action' => 'index'));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'rolesAvailable' => $rolesAvailable
        ));
    }

    public function editAction() {

        $this->layout('layout/devadmin');

        $idUser = $this->params()->fromQuery('id');
        
        $user = $this->getServiceLocator()
                ->get('UserRepository')
                ->findById($idUser);

        $available = $this->getServiceLocator()
                ->get('RolRepository')
                ->findAvailable($idUser);

        $assigned = $this->getServiceLocator()
                ->get('RolRepository')
                ->findAssigned($idUser);

        $form = new UserForm();
        $form->populateValues($user->getArrayCopy());

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
                $user->exchangeArray($data);
                $this->getServiceLocator()->get('UserRepository')->save($user);
                $this->flashMessenger()->addMessage(array('msg' => "La acción se ha efectuado correctamente."));
                return $this->redirect()->toRoute('devadmin/default', array('controller' => 'users', 'action' => 'edit'), array('query' => array('id' => $idUser)));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'user' => $user,
            'available' => $available,
            'assigned' => $assigned,
            'messages' => $messages
        ));
    }

}
