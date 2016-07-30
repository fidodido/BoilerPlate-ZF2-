<?php

namespace DevAdmin\Event;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class RequirementListener implements ListenerAggregateInterface {

    protected $listeners = array();

    public function attach(EventManagerInterface $events, $priority = 100) {

        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), $priority);
    }

    public function detach(EventManagerInterface $events) {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function onDispatch(MvcEvent $e) {

        $this->checkDirectoryPermission();

        //
        $check = false;

        $services = $e->getApplication()->getServiceManager();
        $mysqli = $services->get('db')->getDriver()->getConnection()->getResource();

        //  check if table app_menu exist.
        $resultNav = $mysqli->query("SHOW TABLES LIKE 'app_navegacion'");

        $existTableAppNav = $resultNav->num_rows == 1 ? true : false;

        $resultConfig = $mysqli->query("SHOW TABLES LIKE 'app_config'");

        $existTableConfig = $resultConfig->num_rows == 1 ? true : false;


        if (!$existTableAppNav || $existTableConfig) {

            // derivar a template.
        }
    }

    /*
     * Realiza un check de permisos
     * En los directorios especificados.
     */

    private function checkDirectoryPermission() {

        $publicDir = getcwd() . DIRECTORY_SEPARATOR . 'public';

        $iconPath = $publicDir . DIRECTORY_SEPARATOR . 'icons';

        if (!file_exists($iconPath) && !is_dir($iconPath)) {

            $return = mkdir($iconPath, 0777, true);
        }
    }

}
