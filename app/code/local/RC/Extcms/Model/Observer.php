<?php

/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/15/15
 * Time: 15:19
 */
class RC_Extcms_Model_Observer
{
    /**
     * Add additional field for new CMS page attribute
     *
     * @param Varien_Event_Observer $observer
     */
    public function addCategoryCmsField(Varien_Event_Observer $observer) {
        //get CMS model with data
        $model = Mage::registry('cms_page');
        //get form instance
        $form = $observer->getForm();
        //create new custom fieldset 'extcms_content_fieldset'
        $fieldset = $form->addFieldset('extcms_content_fieldset', array('legend' => Mage::helper('cms')
                ->__('RaceChip Extension'), 'class' => 'fieldset-wide'));
        //add new field
        $fieldset->addField(RC_Extcms_Helper_Data::CATEGORY_ATTRIBUTE_NAME, 'text', array(
            'name' => RC_Extcms_Helper_Data::CATEGORY_ATTRIBUTE_NAME,
            'label' => Mage::helper('cms')->__(RC_Extcms_Helper_Data::CATEGORY_ATTRIBUTE_TITLE),
            'title' => Mage::helper('cms')->__(RC_Extcms_Helper_Data::CATEGORY_ATTRIBUTE_TITLE),
            'disabled' => false,
            //set field value
            'value' => $model->getData(RC_Extcms_Helper_Data::CATEGORY_ATTRIBUTE_NAME)
        ));
    }
}