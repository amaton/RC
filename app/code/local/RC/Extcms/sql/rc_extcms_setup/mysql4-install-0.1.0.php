<?php
/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/15/15
 * Time: 14:48
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

//Creates new field in cms_page table
$installer->getConnection()->addColumn(
    $installer->getTable('cms_page'),
    RC_Extcms_Helper_Data::CATEGORY_ATTRIBUTE_NAME,
    Varien_Db_Ddl_Table::TYPE_VARCHAR . '(255)'
);


$installer->endSetup();