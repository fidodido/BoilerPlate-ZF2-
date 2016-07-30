<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LiquidacionesController extends AbstractActionController {

    private $months = array(
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
    );

    public function indexAction() {

        $liquidaciones = $this->getServiceLocator()
                ->get(\Repository\Entity\Repository::ORACLE)
                ->findLiquidaciones();

        return new ViewModel(array(
            'liquidaciones' => $liquidaciones,
            'months' => $this->months
        ));
    }

    public function generarPdfAction() {

        $per = $this->params()->fromQuery('per');

        $repository = $this->getServiceLocator()
                ->get(\Repository\Entity\Repository::ORACLE);

        $debito = $repository->findLiquidacionDebito($per);
        $haberes = $repository->findLiquidacionHaber($per);
        $body = $repository->findLiquidacionEncabezado($per);

        $data = array(
            'debito' => $debito,
            'haberes' => $haberes,
            'body' => $body,
        );

        $pdf = $this->getServiceLocator()
                ->get('PdfReports')
                ->get(\Application\Report\Pdf::LIQUIDACION_PERIODO, $data);

        $name = 'liquidacion_' . uniqid() . '.pdf';
        $pdf->Output($name, 'I');
    }

}
