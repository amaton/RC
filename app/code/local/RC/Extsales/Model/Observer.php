<?php

/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/15/15
 * Time: 19:43
 */
class RC_Extsales_Model_Observer
{
    /**
     * Add invoice PDF to order confirmation email;
     * Listen to 'sales_order_send_new_email_before' event
     *
     * @param Varien_Event_Observer $observer
     */
    public function addInvoicePdf(Varien_Event_Observer $observer) {
        //get mailer instance
        $mailer = $observer->getMailer();

        //get order instance
        /** @var $order Mage_Sales_Model_Order */
        $order = $observer->getOrder();
        $storeId = $order->getStoreId();

        //generating array of invoices from collection
        $invoicesCollection = $order->getInvoiceCollection();
        $invoicesArray = array();
        foreach ($invoicesCollection as $_invoice) {
            $invoicesArray[] = $_invoice;
        }

        if (count($invoicesArray) > 0) {
            if (!Mage::getStoreConfig(RC_Extsales_Helper_Data::XML_PATH_EMAIL_ATTACHED_USE_DEFAULT_PDF_TEMPLATE, $storeId)) {
                //Generating invoice by predefined template
                $pdf = Mage::helper('extsales/pdf')->htmlToPdf(Mage::helper('extsales')
                        ->getInvoiceHtmlForPdf($order, $invoicesArray));
            } else {
                // Generating pdf from all invoices and put them to mailer object
                $pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($invoicesArray)->render();
            }
            $pdfAttachment = Mage::helper('extsales')->createAttachment($pdf);
            // Appending attachment to mailer object
            $attachments = is_array($mailer->getData('attachments')) ? $mailer->getData('attachments') : array();
            $attachments[] = $pdfAttachment;
            $mailer->setAttachments($attachments);
        }
    }
}