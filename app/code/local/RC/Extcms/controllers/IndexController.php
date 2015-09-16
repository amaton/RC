<?php

/**
 * Created by PhpStorm.
 * User: amaton
 * Date: 9/15/15
 * Time: 15:39
 */
class RC_Extcms_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Pages list
     *
     * @return void
     */
    public function indexAction() {
        $this->loadLayout()->renderLayout();
    }
} 