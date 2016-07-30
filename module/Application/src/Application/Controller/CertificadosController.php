<?php

namespace Application\Controller;

use Util\BaseController;
use Zend\View\Model\ViewModel;

class CertificadosController extends BaseController {

    public function indexAction() {
        return new ViewModel(array(
        ));
    }

    public function descargarAction() {

        $id = $this->params()->fromQuery('id');
        $tipo = $this->params()->fromQuery('tipo');
        $firma = $this->params()->fromQuery('firma');

        $repository = $this->getServiceLocator()->get('OracleRepository');
        $output = $repository->getCertificado($id, $tipo);

        $data = array(
            'firma' => $firma,
            'data' => $output
        );

        $pdf = $this->getServiceLocator()
                ->get('PdfReports')
                ->get(\Application\Report\Pdf::RENTA, $data);

        $name = 'certif_' . strtolower($tipo) . '_' . uniqid() . '.pdf';
        $pdf->Output($name . ".pdf", 'I');

        return $this->response;
    }

}
