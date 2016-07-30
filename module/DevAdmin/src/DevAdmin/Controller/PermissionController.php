<?php

namespace DevAdmin\Controller;

use Util\BaseController;
use Zend\View\Model\ViewModel;
use DevAdmin\Model\View\Form\PermissionForm;
use DevAdmin\Model\Entity\Permission;

class PermissionController extends BaseController {

    public function indexAction() {

        $this->layout('layout/devadmin');

        $form = new PermissionForm();
        $repository = $this->getServiceLocator()->get('PermissionRepository');
        $permission = $repository->find();

        $flashMessenger = $this->flashMessenger();
        $messages = array();

        if ($flashMessenger->hasMessages()) {
            $messages = $flashMessenger->getMessages();
        }

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            $form->setInputFilter($form->getInputFilter());
            $newPermission = new Permission();

            if ($form->isValid()) {

                $newPermission->exchangeArray($data);

                $this->getServiceLocator()
                        ->get('PermissionRepository')
                        ->save($newPermission);
                
                return $this->redirect()->toRoute('devadmin/default', array('controller' => 'permission', 'action' => 'index'));
            }
        }

        return new ViewModel(array(
            'permission' => $permission,
            'messages' => $messages,
            'form' => $form
        ));
    }

}
