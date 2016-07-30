<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class Module {

    private $flashMessenger;

    public function init() {

        date_default_timezone_set("Chile/Continental");

        $config = $this->getConfig();
        \Logger::configure($config['log4php']);
    }

    public function onBootstrap(MvcEvent $e) {

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->addTranslationFile(
                'phpArray', './vendor/zendframework/zendframework/resources/languages/es/Zend_Validate.php', 'default', 'es'
        );

        // sobre-escribimos la configuracion de la base de datos.
        $identity = $e->getApplication()->getServiceManager()->get('IdentityManager')->getIdentity();

        $eventManager->attach('dispatch.error', array($this, 'onRenderError'), 100);

        if (null !== $identity) {

            $config = $e->getApplication()->getServiceManager()->get('config');

            $config['oradb']['username'] = $identity->getUsername();
            $config['oradb']['password'] = $identity->getCredential();

            $e->getApplication()->getServiceManager()->setAllowOverride(true);
            $e->getApplication()->getServiceManager()->setService('Config', $config);
            $e->getApplication()->getServiceManager()->setAllowOverride(false);
        }

        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $viewModel->messages = $this->getFlashMessenger()->getMessages();

        $translator->setLocale('es');
        \Zend\Validator\AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'PdfReports' => function($serviceLocator) {
                    $pdf = new \Application\Report\Pdf();
                    $pdf->setServiceLocator($serviceLocator);
                    return $pdf;
                },
            ),
        );
    }

    public function onRenderError($e) {

        $error = $e->getError();
        $controller = $e->getTarget();

        if ($error == 'error-exception') {

            $exception = $e->getParam('exception');

            if (get_class($exception) == 'Padcore\Exception\BusinessException') {

                $data = $controller->params()->fromPost();

                $flashMessenger = $this->getFlashMessenger();
                $flashMessenger->addMessage(array(
                    'message' => $exception->getMessage(),
                    'className' => \Util\Message::CLASS_ERROR
                ));

                $url = $e->getRequest()->getServer('HTTP_REFERER');
                $controller->plugin('redirect')->toUrl($url);

                $e->stopPropagation();
                return FALSE;
            }
        }
    }

    private function getFlashMessenger() {

        if (!$this->flashMessenger) {
            $this->flashMessenger = new FlashMessenger();
        }

        return $this->flashMessenger;
    }

}
