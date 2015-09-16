<?php

/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/15/15
 * Time: 15:09
 */
class RC_Extsales_Helper_Data extends Mage_Core_Helper_Abstract
{
    //Contains config paths for invoice pdf template
    const XML_PATH_EMAIL_ATTACHED_INVOICE_PDF_TEMPLATE = 'extsales/pdf_templates/invoice_pdf_template';
    //Contains config path for switcher to default pdf generation
    const XML_PATH_EMAIL_ATTACHED_USE_DEFAULT_PDF_TEMPLATE = 'extsales/pdf_templates/use_default';

    public function createAttachment($data) {
        return Mage::getModel('core/email_template')
            ->getMail()
            ->createAttachment($data, 'application/pdf', Zend_Mime::DISPOSITION_ATTACHMENT,
                Zend_Mime::ENCODING_BASE64, 'invoice.pdf');
    }

    public function getInvoiceHtmlForPdf($order, $invoicesCollection = array()) {
        $storeId = $order->getStoreId();

        if (empty($invoicesArray)) {
            //generating array of invoices from collection
            $invoicesCollection = $order->getInvoiceCollection();
            $invoicesArray = array();
            foreach ($invoicesCollection as $_invoice) {
                $invoicesArray[] = $_invoice;
            }
        }
        //Loading Template
        $emailTemplate = Mage::getModel('core/email_template');
        $pdfTemplateId = Mage::getStoreConfig(RC_Extsales_Helper_Data::XML_PATH_EMAIL_ATTACHED_INVOICE_PDF_TEMPLATE, $storeId);
        if (is_numeric($pdfTemplateId)) {
            $emailTemplate->load($pdfTemplateId);
        } else {
            $emailTemplate = Mage::getModel('core/email_template')
                ->loadDefault($pdfTemplateId, Mage::getStoreConfig('general/locale/code', $storeId));
        }

        // Start store emulation process
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);
        try {
            // Retrieve specified view block from appropriate design package (depends on emulated store)
            $paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())
                ->setIsSecureMode(true);
            $paymentBlock->getMethod()->setStore($order->getStoreId());
            $paymentBlockHtml = $paymentBlock->toHtml();
        } catch (Exception $exception) {
            // Stop store emulation process
            $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
            throw $exception;
        }
        // Stop store emulation process
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

        // Getting HTML from predefined template
        $html = $emailTemplate->getProcessedTemplate(array('order' => $order, 'invoice' => $invoicesArray[0],
            'invoices' => $invoicesArray, 'comment' => '', 'billing' => $order->getBillingAddress(),
            'payment_html' => $paymentBlockHtml), true);

        return $html;
    }
}