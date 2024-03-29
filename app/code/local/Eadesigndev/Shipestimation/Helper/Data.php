<?php

/**
 * EaDesgin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@eadesign.ro so we can send you a copy immediately.
 *
 * @category    Eadesigndev_Shipestimation
 * @copyright   Copyright (c) 2008-2015 EaDesign by Eco Active S.R.L.
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

class Eadesigndev_Shipestimation_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Check if module is active
     * @return boolean
     */
    public function isActive()
    {
        return Mage::getStoreConfig('shipestimationopt/shipestimation_opt/active');
    }

    public function ifItApplies()
    {
        $isActive = $this->isActive();
        $_product = Mage::registry('current_product');

        if ($isActive && $_product->getData('type_id') == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE) {
            return true;
        }
        return false;

    }
}