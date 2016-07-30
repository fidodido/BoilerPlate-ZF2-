<?php

namespace Application\Report;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Model\ViewModel;

class Pdf implements ServiceLocatorAwareInterface {

    protected $serviceLocator;

    const LIQUIDACION_PERIODO = 1;
    const RENTA = 2;

    public function __construct() {
        $imgPath = ROOT_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;
        define('K_PATH_IMAGES', $imgPath);
    }

    public function get($report, $data) {

        switch ($report) {

            case self::LIQUIDACION_PERIODO:
                $pdf = $this->getLiquidacionPorPeriodo($data);
                break;
            case self::RENTA:
                $pdf = $this->getCertificadoRenta($data);
                break;
        }

        return $pdf;
    }

    /*
     * return @PDF.
     */

    private function getLiquidacionPorPeriodo($data) {

        $viewRender = $this->getServiceLocator()->get('ViewRenderer');

        // create template
        $layout = new ViewModel();
        $layout->setTemplate("application/liquidaciones/generar-pdf");
        $layout->setVariable("data", $data);

        // render HTML
        $html = $viewRender->render($layout);

        error_reporting(0);

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetPrintFooter(false);
        
        // set document information
        $pdf->SetCreator("PADSYSTEMS");
        $pdf->SetAuthor('PADSYSTEMS');
        $pdf->SetTitle('Resultado Certificacion Persona');
        $pdf->SetSubject('Resultado Certificacion Persona');


        // set default header data
        $pdf->SetHeaderData('padsys_0.png', PDF_HEADER_LOGO_WIDTH, '', '');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(8, 20, 8);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set font
        $pdf->SetFont('times', 'B', 20);

        // add a page
        $pdf->AddPage();

        //$pdf->Write(0, 'Resultado Certificación Persona', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('times', '', 11);
        $pdf->writeHTML($html, true, false, false, false, '');

        return $pdf;
    }

    private function getCertificadoRenta($data) {

        $viewRender = $this->getServiceLocator()->get('ViewRenderer');

        // create template
        $layout = new ViewModel();
        $layout->setTemplate("application/certificados/renta");
        $layout->setVariable("data", $data['data']);
        $layout->setVariable("firma", $data['firma']);
        
        // render HTML
        $html = $viewRender->render($layout);

        error_reporting(0);

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator("PADSYSTEMS");
        $pdf->SetAuthor('PADSYSTEMS');
        $pdf->SetTitle('Resultado Certificacion Persona');
        $pdf->SetSubject('Resultado Certificacion Persona');


        // set default header data
        $pdf->SetHeaderData('padsys_0.png', PDF_HEADER_LOGO_WIDTH, '', '');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set font
        $pdf->SetFont('helvetica', 'B', 20);

        // add a page
        $pdf->AddPage();

        //$pdf->Write(0, 'Certificado de Renta', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 12);
        $pdf->writeHTML($html, true, false, false, false, '');

        return $pdf;
    }

    private function getResultCertPersona($data) {


        $viewRender = $this->getServiceLocator()->get('ViewRenderer');

        // create template
        $layout = new ViewModel();
        $layout->setTemplate("application/liquidaciones/generar-pdf");
        $layout->setVariable("data", $data);

        // render HTML
        $html = $viewRender->render($layout);

        error_reporting(0);

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator("PADSYSTEMS");
        $pdf->SetAuthor('PADSYSTEMS');
        $pdf->SetTitle('Resultado Certificacion Persona');
        $pdf->SetSubject('Resultado Certificacion Persona');


        // set default header data
        //$pdf->SetHeaderData('logo.png', PDF_HEADER_LOGO_WIDTH, 'Reportes', 'Sistema de Certificaciones');
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set font
        $pdf->SetFont('helvetica', 'B', 20);

        // add a page
        $pdf->AddPage();

        //$pdf->Write(0, 'Resultado Certificación Persona', '', 0, 'C', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 8);
        $pdf->writeHTML($html, true, false, false, false, '');

        return $pdf;
    }

    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

}
