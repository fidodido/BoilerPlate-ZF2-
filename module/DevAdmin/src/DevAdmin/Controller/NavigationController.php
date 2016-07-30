<?php

namespace DevAdmin\Controller;

use Util\BaseController;
use Zend\View\Model\ViewModel;
use DevAdmin\Model\View\Form\OptionMenuForm;
use DevAdmin\Model\Entity\OptionMenu;

class NavigationController extends BaseController {

    public function indexAction() {

        $this->layout('layout/devadmin');
        $parent = $this->params()->fromQuery('parent');
        $repository = $this->getServiceLocator()->get('MenuRepository');
        $pages = $repository->find(null, $parent);

        return new ViewModel(array(
            'pages' => $pages,
            'messages' => $this->getFlashMessages(),
            'parent' => $parent
        ));
    }

    public function addAction() {

        $this->layout('layout/devadmin');
        $parent = $this->params()->fromQuery('parent');
        $repository = $this->getServiceLocator()->get('MenuRepository');
        $pages = $repository->find(null, null);

        $form = new OptionMenuForm();
        $form->get('parent')->setValue($parent);
        $form->setParentValues($pages);

        if ($this->getRequest()->isPost()) {

            $array = $this->params()->fromPost();
            $form->setData($array);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {
                $optionMenu = new OptionMenu();
                $optionMenu->exchangeArray($array);
                $repository->save($optionMenu);
                $this->flashMessenger()->addMessage(array('msg' => \Util\Message::SUCCESS));
                return $this->redirect()->toRoute('devadmin/default', array('controller' => 'navigation', 'action' => 'index'), array('query' => array('parent' => $parent)));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'parent' => $parent,
            'messages' => $this->getFlashMessages(),
        ));
    }

    public function editAction() {

        $this->layout('layout/devadmin');
        $repository = $this->getServiceLocator()->get('MenuRepository');
        $id = $this->params()->fromQuery('id');
        $pages = $repository->find(null, null);
        $optionMenu = $repository->findById($id);

        $form = new OptionMenuForm();
        $form->populateValues($optionMenu->getArrayCopy());
        $form->setParentValues($pages);

        if ($this->getRequest()->isPost()) {

            $array = $this->params()->fromPost();
            $form->setData($array);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {
                $optionMenu = new OptionMenu();
                $optionMenu->exchangeArray($array);
                $repository->save($optionMenu);
                $this->flashMessenger()->addMessage(array('msg' => \Util\Message::SUCCESS));
                return $this->redirect()->toRoute('devadmin/default', array('controller' => 'navigation', 'action' => 'index'));
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'id' => $id,
            'messages' => $this->getFlashMessages(),
        ));
    }

}
