<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SolicitudesController extends AbstractActionController {

    public function misSolicitudesAction() {

        $solicitudes = $this->getServiceLocator()
                ->get(\Repository\Entity\Repository::ORACLE)
                ->findMisSolicitudes();

        return new ViewModel(array(
            'solicitudes' => $solicitudes
        ));
    }

    public function solicitudesPorAprobarAction() {

        $solicitudesPendientes = $this->getServiceLocator()
                ->get(\Repository\Entity\Repository::ORACLE)
                ->findSolicitudesPorAprobar();
       

        return new ViewModel(array(
            'solicitudesPendientes' => $solicitudesPendientes
        ));
    }

}
