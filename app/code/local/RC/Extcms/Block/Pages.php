<?php

/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/15/15
 * Time: 15:56
 */
class RC_Extcms_Block_Pages extends Mage_Core_Block_Template
{
    /**
     * Get pages grouped by category.
     *
     * @return Mage_Core_Model_Resource_Db_Collection_Abstract
     */
    public function getCategoryPagesForList() {
        return Mage::getModel('cms/page')->getCategoryPagesForList();
    }
}