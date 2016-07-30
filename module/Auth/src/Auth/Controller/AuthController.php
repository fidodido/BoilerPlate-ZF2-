<?php

namespace Auth\Controller;

use Zend\Authentication\Result;
use Util\BaseController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Auth\Form\AuthenticationForm;

class AuthController extends BaseController {

    public function loginAction() {

        $this->layout('layout/login');
        
        $form = new AuthenticationForm();

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setInputFilter($form->getInputFilter());
            $form->setData($data);

            if ($form->isValid()) {

                // obtenemos los datos ingresados.
                $identity = $this->params()->fromPost('identity');
                $credential = $this->params()->fromPost('credential');

                // llamos al administrador de identidad, nos debe devolver el resultado.
                $identityManager = $this->getServiceLocator()->get('IdentityManager');

                // Y finalmente, llamamos al metodo login.
                $result = $identityManager->login($identity, $credential);

                // este metodo devuelve un objeto tipo Result, con un codigo.
                switch ($result->getCode()) {

                    case Result::FAILURE:

                        $this->flashMessenger()->addMessage(array(
                            'className' => \Util\Message::CLASS_ERROR,
                            'message' => 'Usuario o Password inválidos.'
                        ));

                        $this->redirect()->toRoute('login');
                        break;

                    case Result::SUCCESS:

                        $identityManager->getAuthService()->getStorage()->setRememberMe(1);
                        $identityManager->storeIdentity($result->getIdentity());

                        $this->flashMessenger()->addMessage(array(
                            'className' => \Util\Message::CLASS_SUCCESS,
                            'message' => 'Bienvenido: ' . $result->getIdentity()->getNombreCompleto()
                        ));

                        $this->redirect()->toRoute('home');
                    default:
                        break;
                }
            }
        }

        $viewModel = new ViewModel(array(
            "form" => $form
        ));

        return $viewModel;
    }

    public function logoutAction() {

        $session = new Container('adminceim');
        $session->getManager()->getStorage()->clear('base');
        $session->getManager()->getStorage()->clear('application');

        $locator = $this->getServiceLocator();
        $identityManager = $locator->get('IdentityManager');
        $identityManager->logout();
        $this->redirect()->toRoute('login');
        return $this->response;
    }

    public function cambiarClaveAction() {

        $form = new \Auth\Form\CambiarClaveForm();

        if ($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();
            $form->setData($data);
            $form->setInputFilter($form->getInputFilter());

            if ($form->isValid()) {

                $this->getServiceLocator()
                        ->get(\Repository\Entity\Repository::ORACLE)
                        ->cambiarClave($form);
                
                $this->redirect()->toRoute('logout');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

}
