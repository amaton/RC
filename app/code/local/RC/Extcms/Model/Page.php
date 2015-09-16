<?php

/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/15/15
 * Time: 17:17
 */
class RC_Extcms_Model_Page extends Mage_Cms_Model_Page
{
    /**
     * Get pages grouped by category.
     *
     * @param $direction ASC or DESC
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    public function getCategoryPagesForList($direction = Zend_Db_Select::SQL_DESC) {
        return $this->getCollection()->addFieldToSelect('title')
            ->addFieldToSelect('identifier')
            ->addFieldToSelect(RC_Extcms_Helper_Data::CATEGORY_ATTRIBUTE_NAME)
            ->setOrder(RC_Extcms_Helper_Data::CATEGORY_ATTRIBUTE_NAME, $direction);
    }
}