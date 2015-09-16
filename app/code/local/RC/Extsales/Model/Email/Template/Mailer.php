<?php

/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/16/15
 * Time: 13:43
 */
class RC_Extsales_Model_Email_Template_Mailer extends Mage_Core_Model_Email_Template_Mailer
{
    /**
     * {@inheritdoc}
     * @see self::$_emailInfos
     *
     * @return Mage_Core_Model_Email_Template_Mailer
     */
    public function send() {
        /** @var $emailTemplate Mage_Core_Model_Email_Template */
        $emailTemplate = Mage::getModel('core/email_template');

        //Attachment extension begin
        $attachments = $this->getAttachments();
        if (is_array($attachments) and count($attachments) > 0) {
            //add All Attachments from $this and pass them into mail
            foreach ($attachments as $attachment) {
                if ($attachment instanceof Zend_Mime_Part) {
                    $emailTemplate->getMail()->addAttachment($attachment);
                }
            }
        } else {
            // Put message to queue in case of no attachemnts
            $emailTemplate->setQueue($this->getQueue());
        }
        //Attachment extension end

        // Send all emails from corresponding list
        while (!empty($this->_emailInfos)) {
            $emailInfo = array_pop($this->_emailInfos);
            // Handle "Bcc" recipients of the current email
            $emailTemplate->addBcc($emailInfo->getBccEmails());
            // Set required design parameters and delegate email sending to Mage_Core_Model_Email_Template
            $emailTemplate->setDesignConfig(array('area' => 'frontend', 'store' => $this->getStoreId()))
                ->sendTransactional(
                    $this->getTemplateId(),
                    $this->getSender(),
                    $emailInfo->getToEmails(),
                    $emailInfo->getToNames(),
                    $this->getTemplateParams(),
                    $this->getStoreId()
                );
        }
        return $this;
    }


}