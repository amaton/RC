<?php

/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/15/15
 * Time: 15:09
 */
class RC_Extsales_Helper_Pdf extends Mage_Core_Helper_Abstract
{
    public function htmlToPdf($html, $invoicesArray = array()) {
        if (class_exists('RC_PDF')) {
            // Rendering PDF attachment from HTML via tcpdf Library
            $pdf = new RC_PDF();
            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, '');
            // reset pointer to the last page
            $pdf->lastPage();
            $pdf = $pdf->Output('invoice.pdf', 'S');
        } else if (!empty($invoicesArray)) {
            //Fallback to default functionality
            $pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoicesArray)->render();
        } else {
            return false;
        }
        return $pdf;
    }
}